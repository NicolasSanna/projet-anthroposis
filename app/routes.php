<?php 

/**
 * On définit le tableau des routes : on associe à chaque route une classe
 */
$routes = [

    // Route de la page d'accueil
    'homepage' => [
        'path' => '/',
        'controller' => 'HomeController',
        'method' => 'index'
    ],

    '404' => [
        'path' => '/404',
        'controller' => 'HomeController',
        'method' => 'notFound'
    ],
    '403' => [
        'path' => '/403',
        'controller' => 'HomeController',
        'method' => 'forbidden'
    ]
];

// On fait de route une constante.
define('ROUTES', $routes);

// On renvoie le tableau associatif de routes.
return $routes;