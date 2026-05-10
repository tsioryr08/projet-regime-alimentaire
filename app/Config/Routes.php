<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function() {
    return redirect()->to('/utilisateur/register');
});

$routes->group('utilisateur', ['namespace' => 'App\Controllers\user'], function($routes){

    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::loginPost');

	$routes->get('logout','ProfilController::logout');

    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::registerPost');

	$routes->get('profil','ProfilController::profil');
	$routes->get('modifProfil','ProfilController::modif');

});

// Routes IMC
$routes->get('/imc', 'Imc::index');
$routes->post('/imc/calculer', 'Imc::calculer');
$routes->get('/imc/export-pdf', 'Imc::exportPdf');
$routes->match(['get', 'post'], '/imc/resultat', 'Imc::resultat');

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
        $routes->match(['get', 'post'], 'codes/validation/(:num)', 'CodeAdminController::validation/$1');

        $routes->match(['get', 'post'], 'parametres', 'ParametreController::index');
        $routes->match(['get', 'post'], 'parametres/create', 'ParametreController::create');
        $routes->get('parametres/delete/(:num)', 'ParametreController::delete/$1');
    });
});


// Admin home (redirect based on auth status)
$routes->get('admin', 'Admin\Index::home');
$routes->get('admin/', 'Admin\Index::home');

// Front : suggestions régimes/activités
$routes->match(['get','post'], 'regime/suggestion', 'Regime::suggestion');
$routes->post('regime/toggleGold', 'Regime::toggleGold');
