<?php

namespace App\Models;

use CodeIgniter\Model;

class StatistiqueModel extends Model
{
    public function utilisateursParObjectif(): array
    {
        return $this->db->table('utilisateurs')
            ->select('objectif, COUNT(*) AS total')
            ->groupBy('objectif')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function regimesPopulaires(): array
    {
        return $this->db->table('suggestions s')
            ->select('r.nom, COUNT(s.id) AS total')
            ->join('regimes r', 'r.id = s.regime_id', 'left')
            ->groupBy('r.id, r.nom')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function repartitionGold(): array
    {
        return $this->db->table('utilisateurs')
            ->select('is_gold, COUNT(*) AS total')
            ->groupBy('is_gold')
            ->orderBy('is_gold', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function resumeDashboard(): array
    {
        $totalUtilisateurs = (int) $this->db->table('utilisateurs')->countAllResults();
        $totalRegimes = (int) $this->db->table('regimes')->countAllResults();
        $totalActivites = (int) $this->db->table('activites')->countAllResults();
        $totalCodes = (int) $this->db->table('codes')->countAllResults();

        return [
            'totalUtilisateurs' => $totalUtilisateurs,
            'totalRegimes'      => $totalRegimes,
            'totalActivites'    => $totalActivites,
            'totalCodes'        => $totalCodes,
        ];
    }
}
