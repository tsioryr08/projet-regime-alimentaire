<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StatistiqueModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $statsModel = new StatistiqueModel();

        $resume = $statsModel->resumeDashboard();
        $utilisateursParObjectif = $statsModel->utilisateursParObjectif();
        $regimesPopulaires = $statsModel->regimesPopulaires();
        $repartitionGold = $statsModel->repartitionGold();

        return view('admin/dashboard', [
            'resume' => $resume,
            'utilisateursParObjectif' => $utilisateursParObjectif,
            'regimesPopulaires' => $regimesPopulaires,
            'repartitionGold' => $repartitionGold,
        ]);
    }
}
