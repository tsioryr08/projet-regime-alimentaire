<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Index extends BaseController
{
    public function home()
    {
        $session = session();
        
        // if logged in and has admin role, go to dashboard
        if ($session->get('isLoggedIn') && in_array($session->get('role'), ['admin','superadmin'])) {
            return redirect()->to(site_url('admin/dashboard'));
        }
        
        // else redirect to login
        return redirect()->to(site_url('admin/auth/login'));
    }
}
