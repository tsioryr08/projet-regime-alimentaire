<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Routes Étudiant
$routes->get('/etudiant', 'Etudiant::index');

