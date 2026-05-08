<?php

namespace App\Controllers;

use App\Models\EtudiantModel;

class Etudiant extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new EtudiantModel();
    }

    public function index()
    {
        $data['etudiants'] = $this->model->findAll();
        return view('Etudiant', $data);
    }
}
