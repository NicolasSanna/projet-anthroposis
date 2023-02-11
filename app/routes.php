<?php 

/**
 * On définit le tableau des routes : on associe à chaque route une classe
 */
$routes = [

    // Route de la page d'accueil
    'home' => [
        'path' => '/',
        'controller' => 'HomeController',
        'method' => 'index'
    ],

    'signup' => [
        'path' => '/inscription',
        'controller' => 'Account\\AccountController',
        'method' => 'signup'
    ],

    'dashboard' => [
        'path' => '/admin/administration',
        'controller' => 'Admin\\AdminController',
        'method' => 'dashboard'
    ],

    'articles' => [
        'path' => '/admin/articles',
        'controller' => 'Admin\\AdminController',
        'method' => 'articles'
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