<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table            = 'codes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'code',
        'montant',
        'est_valide',
        'utilisateur_id',
        'date_utilisation'
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'code' => 'required|max_length[50]|is_unique[codes.code,id,{id}]',
        'montant' => 'required|decimal|greater_than[0]',
        'est_valide' => 'permit_empty|integer|in_list[0,1]',
        'utilisateur_id' => 'permit_empty|is_natural_no_zero',
        'date_utilisation' => 'permit_empty|valid_date'
    ];

    protected $validationMessages = [
        'code' => [
            'required' => 'Le code est obligatoire',
            'is_unique' => 'Ce code existe déjà'
        ],
        'montant' => [
            'required' => 'Le montant est obligatoire',
            'greater_than' => 'Le montant doit être supérieur à 0'
        ]
    ];

    public function verifierCode($code)
    {
        return $this->where('code', $code)
                    ->where('est_valide', 1)
                    ->where('utilisateur_id IS NULL', null, false)
                    ->first();
    }


    public function utiliserCode($code, $utilisateurId)
    {
        $codeInfo = $this->verifierCode($code);
        
        if (!$codeInfo) {
            return [
                'success' => false,
                'message' => 'Code invalide ou déjà utilisé',
                'montant' => 0
            ];
        }

        $dejaUtilise = $this->where('code', $code)
                            ->where('utilisateur_id', $utilisateurId)
                            ->first();
        
        if ($dejaUtilise) {
            return [
                'success' => false,
                'message' => 'Vous avez déjà utilisé ce code',
                'montant' => 0
            ];
        }

        $update = $this->update($codeInfo['id'], [
            'est_valide' => 0,
            'utilisateur_id' => $utilisateurId,
            'date_utilisation' => date('Y-m-d H:i:s')
        ]);

        if (!$update) {
            return [
                'success' => false,
                'message' => 'Erreur lors de l\'utilisation du code',
                'montant' => 0
            ];
        }

        return [
            'success' => true,
            'message' => 'Code utilisé avec succès',
            'montant' => $codeInfo['montant']
        ];
    }

    public function creerCode($code, $montant)
    {
        return $this->insert([
            'code' => strtoupper($code),
            'montant' => $montant,
            'est_valide' => 1,
            'utilisateur_id' => null,
            'date_utilisation' => null
        ]);
    }

 
    public function getCodesValides()
    {
        return $this->where('est_valide', 1)
                    ->where('utilisateur_id IS NULL', null, false)
                    ->findAll();
    }

 
    public function getCodesUtilisesParUtilisateur($utilisateurId)
    {
        return $this->where('utilisateur_id', $utilisateurId)
                    ->orderBy('date_utilisation', 'DESC')
                    ->findAll();
    }


    public function getTotalGagneParUtilisateur($utilisateurId)
    {
        return $this->select('SUM(montant) as total')
                    ->where('utilisateur_id', $utilisateurId)
                    ->first()['total'] ?? 0;
    }
}