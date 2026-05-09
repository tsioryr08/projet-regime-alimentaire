<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Routes Étudiant
$routes->get('/etudiant', 'Etudiant::index');

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
