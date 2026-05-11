<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'categorie_imc', 'sens_variation', 'description', 'prix_base', 'duree_jours'];

   //suggestion de regime
    public function suggestRegimes(string $categorie_imc, string $objectif): array
    {
        // Mapper l'objectif sur le sens de variation attendu
        $map = [
            'augmenter_poids' => 'prise',
            'reduire_poids' => 'perte',
            'atteindre_imc_ideal' => 'stabilite',
        ];

        $sens = $map[$objectif] ?? null;

        $builder = $this->builder();

        if ($sens) {
            $builder->where('categorie_imc', $categorie_imc)->where('sens_variation', $sens);
        } else {
            // Si aucun sens trouvé, retourner par catégorie uniquement
            $builder->where('categorie_imc', $categorie_imc);
        }

        $results = $builder->get()->getResultArray();

        // Si pas de resultat, essayer une recherche plus large
        if (empty($results)) {
            $results = $this->where('categorie_imc', $categorie_imc)->findAll(5);
        }

        return $this->deduplicateRegimes($results);
    }

    private function deduplicateRegimes(array $regimes): array
    {
        $seen = [];
        $unique = [];

        foreach ($regimes as $regime) {
            $key = implode('|', [
                $regime['nom'] ?? '',
                $regime['description'] ?? '',
                $regime['prix_base'] ?? '',
                $regime['duree_jours'] ?? '',
                $regime['sens_variation'] ?? '',
                $regime['categorie_imc'] ?? '',
            ]);

            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $unique[] = $regime;
        }

        return $unique;
    }
}
