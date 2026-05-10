<?php

namespace App\Models;

use CodeIgniter\Model;

class ImcModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nom', 'email', 'genre', 'taille', 'poids', 'date_inscription'];

   //CALCUL imc , POIDS(KG) / TAILLE(M)²
    public function calculerImc($poids, $taille)
    {
    //conversion
        $taille_m = $taille / 100;
        
        if ($taille_m <= 0) {
            return 0;
        }
        
        $imc = $poids / ($taille_m * $taille_m);
        return round($imc, 2);
    }

   //determination de la categorie imc
    public function getCategorieImc($imc)
    {
        if ($imc < 18.5) {
            return [
                'categorie' => 'Maigreur',
                'couleur' => 'info',
                'description' => 'Vous êtes en situation de maigreur',
                'code' => 'maigreur'
            ];
        } elseif ($imc >= 18.5 && $imc < 25) {
            return [
                'categorie' => 'Normal',
                'couleur' => 'success',
                'description' => 'Vous avez un poids normal',
                'code' => 'normal'
            ];
        } elseif ($imc >= 25 && $imc < 30) {
            return [
                'categorie' => 'Surpoids',
                'couleur' => 'warning',
                'description' => 'Vous êtes en surpoids',
                'code' => 'surpoids'
            ];
        } else {
            return [
                'categorie' => 'Obésité',
                'couleur' => 'danger',
                'description' => 'Vous êtes en situation d\'obésité',
                'code' => 'obesite'
            ];
        }
    }

    //tt les infos de l'imc dans un tableau
    public function analyserImc($poids, $taille)
    {
        $imc = $this->calculerImc($poids, $taille);
        $categorie = $this->getCategorieImc($imc);
        
        return [
            'imc' => $imc,
            'poids' => $poids,
            'taille' => $taille,
            'categorie' => $categorie['categorie'],
            'code_categorie' => $categorie['code'],
            'couleur' => $categorie['couleur'],
            'description' => $categorie['description']
        ];
    }
}
