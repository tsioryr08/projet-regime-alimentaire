<?php

use App\Controllers\user\ProfilController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('utilisateur', ['namespace' => 'App\Controllers\user'], function($routes){

    //a faire : asina resaka filtre amin'zay tsy afaka modifier tout ze te himodif
    //login et logout
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::loginPost');
    $routes->get('logout', 'ProfilController::logout');

    //creation compte
    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::registerPost');

    //accueil utilisateur apres connexion/inscription
    $routes->get('accueil', 'ProfilController::accueil');

    //resaka profil
    $routes->get('profil', 'ProfilController::profil');
    $routes->get('modifProfil', 'ProfilController::modif');
    $routes->post('updateProfil', 'ProfilController::modifProfil');

    //resaka code
    $routes->get('saisirCode', 'WalletController::saisir');
    $routes->post('traiterCode', 'WalletController::traiterCode');

    //resaka gold
    $routes->get('devenirGold', 'ProfilController::devenirGold');
    $routes->get('payerGold', 'ProfilController::payerGold');

});

// Routes IMC
$routes->get('/imc', 'Imc::index');
$routes->post('/imc/calculer', 'Imc::calculer');
$routes->get('/imc/export-pdf', 'Imc::exportPdf');
$routes->match(['get', 'post'], '/imc/resultat', 'Imc::resultat');
$routes->post('imc/commander', 'Regime::commander');

// Admin routes (auth)
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes){
    $routes->get('auth/login', 'Auth::login');
    $routes->post('auth/login', 'Auth::loginPost');
    $routes->get('auth/logout', 'Auth::logout');
    // Protect admin routes by default
    $routes->group('', ['filter' => 'adminAuth'], function($routes){
        $routes->get('dashboard', 'DashboardController::index');

        $routes->get('regimes', 'RegimeAdminController::index');
        $routes->match(['get', 'post'], 'regimes/create', 'RegimeAdminController::create');
        $routes->match(['get', 'post'], 'regimes/edit/(:num)', 'RegimeAdminController::edit/$1');

        $routes->get('activites', 'ActiviteAdminController::index');
        $routes->match(['get', 'post'], 'activites/create', 'ActiviteAdminController::create');
        $routes->match(['get', 'post'], 'activites/edit/(:num)', 'ActiviteAdminController::edit/$1');

        $routes->get('codes', 'CodeAdminController::index');
        $routes->match(['get', 'post'], 'codes/create', 'CodeAdminController::create');
        $routes->match(['get', 'post'], 'codes/validation/(:num)', 'CodeAdminController::validation/$1');

        $routes->match(['get', 'post'], 'parametres', 'ParametreController::index');
        $routes->match(['get', 'post'], 'parametres/create', 'ParametreController::create');
        $routes->get('parametres/delete/(:num)', 'ParametreController::delete/$1');
    });
});


// Admin home placeholder (backend reserved)
$routes->get('admin', 'Admin\Index::home');
$routes->get('admin/', 'Admin\Index::home');

// Front : suggestions régimes/activités
$routes->match(['get','post'], 'regime/suggestion', 'Regime::suggestion');
$routes->post('regime/toggleGold', 'Regime::toggleGold');
