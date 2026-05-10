<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ActiviteAdminController extends BaseController
{
    public function index()
    {
        $activites = db_connect()->table('activites')->orderBy('id', 'DESC')->get()->getResultArray();
        return view('admin/activites/index', ['activites' => $activites]);
    }

    public function create()
    {
        if (strtoupper($this->request->getMethod()) === 'POST') {
            $data = $this->request->getPost([
                'nom','description','duree_semaines','frequence','calories_par_h','categorie_imc','objectif_cible'
            ]);
            db_connect()->table('activites')->insert($data);
            return redirect()->to(site_url('admin/activites'));
        }

        return view('admin/activites/create');
    }

    public function edit($id)
    {
        $db = db_connect();
        if (strtoupper($this->request->getMethod()) === 'POST') {
            $data = $this->request->getPost([
                'nom','description','duree_semaines','frequence','calories_par_h','categorie_imc','objectif_cible'
            ]);
            $db->table('activites')->where('id', $id)->update($data);
            return redirect()->to(site_url('admin/activites'));
        }

        $activite = $db->table('activites')->where('id', $id)->get()->getRowArray();
        return view('admin/activites/edit', ['activite' => $activite]);
    }
}
