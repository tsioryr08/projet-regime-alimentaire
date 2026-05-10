<?php
namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class ProfilController extends BaseController{



    public function profil(){
    helper('session');
    $userId = session()->get('user_id');
    $model = new UtilisateurModel();
    $user = $model->getUserById($userId);
        return view("user/profil",['user'=> $user]);
    }

      public function login(){
        helper('form');
        return view("user/login");
    }

public function logout(){
    session()->destroy();
    return redirect()->to('/');
}
    public function modif(){
        return view("modif/profil");
    }

 

}
