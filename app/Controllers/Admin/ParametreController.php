<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ParametreController extends BaseController
{
    public function index()
    {
        $parametres = db_connect()->table('parametres')->orderBy('cle', 'ASC')->get()->getResultArray();

        if (strtoupper($this->request->getMethod()) === 'POST') {
            foreach ($this->request->getPost('parametres') ?? [] as $id => $values) {
                db_connect()->table('parametres')->where('id', $id)->update([
                    'valeur' => $values['valeur'] ?? '',
                    'description' => $values['description'] ?? null,
                ]);
            }
            return redirect()->to(site_url('admin/parametres'));
        }

        return view('admin/parametres/index', ['parametres' => $parametres]);
    }

    public function create()
    {
        if (strtoupper($this->request->getMethod()) === 'POST') {
            $data = [
                'cle' => $this->request->getPost('cle'),
                'valeur' => $this->request->getPost('valeur'),
                'description' => $this->request->getPost('description') ?: null,
            ];
            db_connect()->table('parametres')->insert($data);
            return redirect()->to(site_url('admin/parametres'));
        }

        return view('admin/parametres/create');
    }

    public function delete($id)
    {
        db_connect()->table('parametres')->where('id', $id)->delete();
        return redirect()->to(site_url('admin/parametres'));
    }
}
