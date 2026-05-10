<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class RegimeAdminController extends BaseController
{
    public function index()
    {
        $regimes = db_connect()->table('regimes')->orderBy('id', 'DESC')->get()->getResultArray();
        return view('admin/regimes/index', ['regimes' => $regimes]);
    }

    public function create()
    {
        if (strtoupper($this->request->getMethod()) === 'POST') {
            $data = $this->request->getPost([
                'nom','description','prix_base','duree_jours','variation_poids','sens_variation',
                'pct_viande','pct_poisson','pct_volaille','categorie_imc'
            ]);
            db_connect()->table('regimes')->insert($data);
            return redirect()->to(site_url('admin/regimes'));
        }

        return view('admin/regimes/create');
    }

    public function edit($id)
    {
        $db = db_connect();
        if (strtoupper($this->request->getMethod()) === 'POST') {
            $data = $this->request->getPost([
                'nom','description','prix_base','duree_jours','variation_poids','sens_variation',
                'pct_viande','pct_poisson','pct_volaille','categorie_imc'
            ]);
            $db->table('regimes')->where('id', $id)->update($data);
            return redirect()->to(site_url('admin/regimes'));
        }

        $regime = $db->table('regimes')->where('id', $id)->get()->getRowArray();
        return view('admin/regimes/edit', ['regime' => $regime]);
    }
}
