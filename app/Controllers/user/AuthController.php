<?php
namespace App\Controllers\user;

use App\Controllers\BaseController;

class AuthController extends BaseController{
    public function register(){
        helper('form');
        return view("user/register");
    }

      public function login(){
        helper('form');
        return view("user/login");
    }

    public function loginPost()
{
    helper('form');
    
    $session = session();
    $model = new \App\Models\UtilisateurModel();
    
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    
    $validation = \Config\Services::validation();
    $validation->setRules([
        'email' => 'required|valid_email',
        'password' => 'required'
    ]);
    
    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $validation->getErrors());
    }
    
    $user = $model->where('email', $email)->first();
    
    if ($user && password_verify($password, $user['password'])) {
        $session->set([
            'user_id' => $user['id'],
            'user_nom' => $user['nom'],
            'user_email' => $user['email'],
            'isLoggedIn' => true
        ]);
        
        return redirect()->to('/utilisateur/profil');
    } else {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Email ou mot de passe incorrect');
    }
}

    public function registerPost()
{
    helper('form');
    $utilisateurModel = new \App\Models\UtilisateurModel();

    $data = [

        'nom' => $this->request->getPost('nom'),

        'prenom' => $this->request->getPost('prenom'),

        'email' => $this->request->getPost('email'),

        'password' => password_hash(
            $this->request->getPost('password'),
            PASSWORD_DEFAULT
        ),

        'genre' => $this->request->getPost('genre'),

        'date_naissance' => $this->request->getPost('date_naissance'),

        'taille' => $this->request->getPost('taille'),

        'poids' => $this->request->getPost('poids'),

        'objectif' => $this->request->getPost('objectif'),

        'solde_portefeuille' => 0,

        'is_gold' => 0
    ];

    if (!$utilisateurModel->save($data)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('errors', $utilisateurModel->errors());
    }

    session()->set([

        'user_id' => $utilisateurModel->getInsertID(),

        'user_nom' => $data['nom'],

        'user_email' => $data['email'],

        'isLoggedIn' => true
    ]);

    return redirect()->to('/utilisateur/profil');
}

}
