<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class CodeAdminController extends BaseController
{
    public function index()
    {
        $codes = db_connect()->table('codes')->orderBy('id', 'DESC')->get()->getResultArray();
        return view('admin/codes/index', ['codes' => $codes]);
    }

    public function validation($id)
    {
        $db = db_connect();
        $code = $db->table('codes')->where('id', $id)->get()->getRowArray();

        if (strtoupper($this->request->getMethod()) === 'POST') {
            $db->table('codes')->where('id', $id)->update([
                'est_valide' => (int) $this->request->getPost('est_valide'),
            ]);
            return redirect()->to(site_url('admin/codes'));
        }

        return view('admin/codes/validation', ['code' => $code]);
    }
}
