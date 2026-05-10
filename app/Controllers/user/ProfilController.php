<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class ProfilController extends BaseController
{
    private const ROUTE_LOGIN = '/utilisateur/login';
    private const ROUTE_PROFIL = '/utilisateur/profil';

    public function accueil()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(self::ROUTE_LOGIN);
        }

        $userId = session()->get('user_id');
        $model = new UtilisateurModel();
        $user = $model->getUserById($userId);

        return view('user/accueil', ['user' => $user]);
    }



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
        
        return redirect()->to(self::ROUTE_PROFIL)->with('success', 'Profil mis à jour avec succès');
    } else {
        return redirect()->back()
            ->withInput()
            ->with('errors', $model->errors());
    }

    
}
public function devenirGold()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to(self::ROUTE_LOGIN)->with('error', 'Veuillez vous connecter');
    }
    
    $userId = session()->get('user_id');
    $model = new \App\Models\UtilisateurModel();
    $user = $model->find($userId);
    
    if ($user['is_gold'] == 1) {
        return redirect()->to(self::ROUTE_PROFIL)->with('error', 'Vous êtes déjà membre Gold !');
    }
    
    return view('user/devenir_gold', ['solde' => $user['solde_portefeuille']]);
}






public function payerGold()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to(self::ROUTE_LOGIN)->with('error', 'Veuillez vous connecter');
    }
    
    $userId = session()->get('user_id');
    $model = new \App\Models\UtilisateurModel();
    $user = $model->find($userId);
    
    $errorMessage = null;
    $errorRoute = null;

    if ($user['solde_portefeuille'] < 10000) {
        $errorMessage = 'Solde insuffisant';
        $errorRoute = '/utilisateur/devenirGold';
    } elseif ($user['is_gold'] == 1) {
        $errorMessage = 'Vous êtes déjà Gold';
        $errorRoute = self::ROUTE_PROFIL;
    }

    if ($errorMessage !== null) {
        return redirect()->to($errorRoute)->with('error', $errorMessage);
    }
    
    $nouveauSolde = $user['solde_portefeuille'] - 10000;
    
    $model->update($userId, [
        'solde_portefeuille' => $nouveauSolde,
        'is_gold' => 1,
        'gold_paid_at' => date('Y-m-d H:i:s')
    ]);

    session()->set([
        'is_gold' => 1
    ]);
    
    return redirect()->to(self::ROUTE_PROFIL)->with('success', 'Félicitations ! Vous êtes maintenant membre Gold ⭐');
}
}
