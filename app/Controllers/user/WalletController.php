<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class WalletController extends BaseController
{



    public function saisir()
    {
        helper('session');
        helper('form');
        return view("user/code");
    }


public function traiterCode()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/utilisateur/login')->with('error', 'Veuillez vous connecter');
    }
    
    helper('form');
    $userId = session()->get('user_id');
    $code = trim($this->request->getPost('code'));
    
    if (empty($code)) {
        return redirect()->back()->with('error', 'Veuillez entrer un code');
    }
    
    $codeModel = new \App\Models\CodeModel();
    $utilisateurModel = new \App\Models\UtilisateurModel();
    
    $resultat = $codeModel->utiliserCode($code, $userId);
    
    if (!$resultat['success']) {
        return redirect()->back()->with('error', $resultat['message']);
    }
    
    $user = $utilisateurModel->find($userId);
    $nouveauSolde = $user['solde_portefeuille'] + $resultat['montant'];
    
    $utilisateurModel->update($userId, [
        'solde_portefeuille' => $nouveauSolde
    ]);
    
    return redirect()->to('/utilisateur/profil')->with('success', 
        "Felicitations ! Vous avez gagné {$resultat['montant']} Ar avec le code {$code}"
    );
}







  



}

