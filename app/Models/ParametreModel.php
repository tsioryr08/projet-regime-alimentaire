<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table = 'parametres';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['cle', 'valeur', 'description', 'updated_at'];

    // Recupere la valeur d'un parametre par sa cle
    public function getValeur($cle, $default = null)
    {
        $param = $this->where('cle', $cle)->first();
        return ($param) ? $param->valeur : $default;
    }

    //recup de la remise dans la bdd, par defaut 15%
    public function getRemiseGold()
    {
        $remise = $this->getValeur('remise_gold', 15);
        return (int)$remise;
    }

    //fallback 50000, ce prix n est pas statique
    public function getPrixGold()
    {
        $prix = $this->getValeur('prix_gold', 50000);
        return (float)$prix;
    }
}

