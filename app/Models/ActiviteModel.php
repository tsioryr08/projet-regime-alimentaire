<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table = 'activites';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'categorie_imc', 'objectif_cible', 'duree_semaines', 'frequence', 'description'];

   //suggestion d'activites selon categorie imc et objectif
    public function suggestActivites(string $categorie_imc, string $objectif): array
    {
        $builder = $this->builder();
        $builder->where('categorie_imc', $categorie_imc)->where('objectif_cible', $objectif);

        $results = $builder->get()->getResultArray();

        if (empty($results)) {
            // fallback : si pas de resultat specifique, proposer par categorie uniquement
            $results = $this->where('categorie_imc', $categorie_imc)->findAll(5);
        }

        return $results;
    }
}
