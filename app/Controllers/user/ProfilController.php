<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class ProfilController extends BaseController
{



    public function profil()
    {
        helper('session');
        $userId = session()->get('user_id');
        $model = new UtilisateurModel();
        $user = $model->getUserById($userId);
        return view("user/profil", ['user' => $user]);
    }

    public function login()
    {
        helper('form');
        return view("user/login");
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    public function modif()
    {
        $userId = session()->get('user_id');
        $model = new UtilisateurModel();
        $user = $model->getUserById($userId);
        return view("user/modif_profil", ['user' => $user]);
    }


  public function modifProfil(){
    helper('form');
    
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/utilisateur/login');
    }
    
    $userId = session()->get('user_id');
    $model = new \App\Models\UtilisateurModel();
    
    $data = [
        'id' => $userId,  
        'nom' => $this->request->getPost('nom'),
        'prenom' => $this->request->getPost('prenom'),
        'email' => $this->request->getPost('email'),
        'genre' => $this->request->getPost('genre'),
        'date_naissance' => $this->request->getPost('date_naissance'),
        'taille' => $this->request->getPost('taille'),
        'poids' => $this->request->getPost('poids'),
        'objectif' => $this->request->getPost('objectif')
    ];
    
    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    } else {
        unset($data['password']);
    }
    
    if ($model->update($userId, $data)) {
        session()->set([
            'user_nom' => $data['nom'],
            'user_email' => $data['email']
        ]);
        
        return redirect()->to('/utilisateur/profil')->with('success', 'Profil mis à jour avec succès');
    } else {
        return redirect()->back()
            ->withInput()
            ->with('errors', $model->errors());
    }

    
}
public function devenirGold()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/utilisateur/login')->with('error', 'Veuillez vous connecter');
    }
    
    $userId = session()->get('user_id');
    $model = new \App\Models\UtilisateurModel();
    $user = $model->find($userId);
    
    if ($user['is_gold'] == 1) {
        return redirect()->to('/utilisateur/profil')->with('error', 'Vous êtes déjà membre Gold !');
    }
    
    return view('user/devenir_gold', ['solde' => $user['solde_portefeuille']]);
}






public function payerGold()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/utilisateur/login')->with('error', 'Veuillez vous connecter');
    }
    
    $userId = session()->get('user_id');
    $model = new \App\Models\UtilisateurModel();
    $user = $model->find($userId);
    
    if ($user['solde_portefeuille'] < 10000) {
        return redirect()->to('/utilisateur/devenirGold')->with('error', 'Solde insuffisant');
    }
    
    if ($user['is_gold'] == 1) {
        return redirect()->to('/utilisateur/profil')->with('error', 'Vous êtes déjà Gold');
    }
    
    $nouveauSolde = $user['solde_portefeuille'] - 10000;
    
    $model->update($userId, [
        'solde_portefeuille' => $nouveauSolde,
        'is_gold' => 1,
        'gold_paid_at' => date('Y-m-d H:i:s')
    ]);
    
    return redirect()->to('/utilisateur/profil')->with('success', 'Félicitations ! Vous êtes maintenant membre Gold ⭐');
}
}
