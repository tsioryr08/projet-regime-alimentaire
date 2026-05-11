<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table            = 'utilisateurs';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;

    protected $protectFields    = true;

    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'password',
        'genre',
        'date_naissance',
        'taille',
        'poids',
        'objectif',
        'solde_portefeuille',
        'is_gold',
        'gold_paid_at'
    ];

    protected $useTimestamps = true;

    protected $dateFormat    = 'datetime';

    protected $createdField  = 'created_at';

    protected $updatedField  = 'updated_at';

    protected $validationRules = [

        'id' => 'permit_empty|is_natural_no_zero',

        'nom' => 'required|min_length[2]|max_length[100]',

        'prenom' => 'required|min_length[2]|max_length[100]',

        'email' => 'required|valid_email|is_unique[utilisateurs.email,id,{id}]',

        'password' => 'required|min_length[6]',

        'genre' => 'required|in_list[homme,femme]',

        'date_naissance' => 'required|valid_date',

        'taille' => 'required|decimal',

        'poids' => 'required|decimal',

        'objectif' => 'required|in_list[augmenter_poids,reduire_poids,imc_ideal]'
    ];

    protected $validationMessages = [

    'nom' => [
        'required'   => 'Le nom est obligatoire.',
        'min_length' => 'Le nom doit contenir au moins 2 caractères.'
    ],

    'prenom' => [
        'required' => 'Le prénom est obligatoire.'
    ],

    'email' => [
        'required'    => 'L’email est obligatoire.',
        'valid_email' => 'Email invalide.',
        'is_unique'   => 'Cet email existe déjà.'
    ],

    'password' => [
        'required'   => 'Le mot de passe est obligatoire.',
        'min_length' => 'Le mot de passe doit contenir au moins 6 caractères.'
    ],

    'genre' => [
        'required' => 'Le genre est obligatoire.',
        'in_list'  => 'Genre invalide.'
    ],

    'taille' => [
        'decimal' => 'La taille doit être un nombre décimal.'
    ]
];

    protected $skipValidation = false;

    public function getUserById($id){
        return $this->find($id);
    }

        public function getSolde($id)
{
    return $this->select('solde_portefeuille')
                ->where('id', $id)
                ->get()
                ->getRow()
                ->solde_portefeuille;
}
    
}