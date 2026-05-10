<?php
namespace App\Controllers\user;

use App\Controllers\BaseController;

class AuthController extends BaseController{
    public function login(){
        return view("user/login");
    }

}
