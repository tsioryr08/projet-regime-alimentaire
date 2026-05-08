<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function login()
    {
        // already logged in
        if (session()->get('isLoggedIn') && in_array(session()->get('role'), ['admin','superadmin'])) {
            return redirect()->to(site_url('admin/dashboard'));
        }

        return view('admin/login');
    }

    public function loginPost()
    {
        $session = session();
        $request = $this->request;

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (! $this->validate($rules)) {
            $session->setFlashdata('error', 'Veuillez renseigner un email valide et un mot de passe.');
            return redirect()->back()->withInput();
        }

        $email = $request->getPost('email');
        $password = $request->getPost('password');

        $model = new AdminModel();
        $admin = $model->findByEmail($email);

        if (! $admin) {
            $session->setFlashdata('error', 'Identifiants invalides.');
            return redirect()->back()->withInput();
        }

        $storedPassword = $admin['password_hash'] ?? $admin['password'] ?? null;
        if (! $storedPassword) {
            $session->setFlashdata('error', 'Compte administrateur mal configuré.');
            return redirect()->back()->withInput();
        }

        $isHashedPassword = str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$argon2');
        $passwordIsValid = $isHashedPassword ? password_verify($password, $storedPassword) : hash_equals($storedPassword, md5($password)) || hash_equals($storedPassword, $password);

        if (! $passwordIsValid) {
            $session->setFlashdata('error', 'Identifiants invalides.');
            return redirect()->back()->withInput();
        }

        // set session and role
        $session->set('isLoggedIn', true);
        $session->set('admin_email', $admin['email']);
        $session->set('role', $admin['role'] ?? 'admin');

        if (in_array($session->get('role'), ['admin','superadmin'], true)) {
            $session->set('isAdmin', true);
            return redirect()->to(site_url('admin/dashboard'));
        }

        // user authenticated but not admin
        $session->setFlashdata('error', 'Accès non autorisé.');
        return redirect()->back()->withInput();
    }

    public function logout()
    {
        session()->remove(['isAdmin','admin_email','isLoggedIn','role']);
        return redirect()->to(site_url('admin/auth/login'));
    }
}
