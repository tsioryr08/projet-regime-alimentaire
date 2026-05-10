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
        'id' => $userId,  // ← AJOUTER L'ID ICI ! C'est important
        'nom' => $this->request->getPost('nom'),
        'prenom' => $this->request->getPost('prenom'),
        'email' => $this->request->getPost('email'),
        'genre' => $this->request->getPost('genre'),
        'date_naissance' => $this->request->getPost('date_naissance'),
        'taille' => $this->request->getPost('taille'),
        'poids' => $this->request->getPost('poids'),
        'objectif' => $this->request->getPost('objectif')
    ];
    
    // Si mot de passe renseigné, le mettre à jour
    $password = $this->request->getPost('password');
    if (!empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Retirer 'password' des données si vide
        unset($data['password']);
    }
    
    // Mise à jour
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
}
