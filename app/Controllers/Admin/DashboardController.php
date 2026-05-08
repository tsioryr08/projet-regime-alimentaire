<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StatistiqueModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $statsModel = new StatistiqueModel();

        return view('admin/dashboard', [
            'resume' => $statsModel->resumeDashboard(),
            'utilisateursParObjectif' => $statsModel->utilisateursParObjectif(),
            'regimesPopulaires' => $statsModel->regimesPopulaires(),
            'repartitionGold' => $statsModel->repartitionGold(),
        ]);
    }
}
