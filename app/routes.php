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

    'login' => [
        'path' => '/connexion',
        'controller' => 'Account\\AccountController',
        'method' => 'login'
    ],

    'logout' => [
        'path' => '/deconnexion',
        'controller' => 'Account\\AccountController',
        'method' => 'logout'
    ],

    'dashboard' => [
        'path' => '/admin/tableau-de-bord',
        'controller' => 'Admin\\AdminController',
        'method' => 'dashboard'
    ],

    'new-article' => [
        'path' => '/admin/nouvel-article',
        'controller' => 'Admin\\Article\\ArticleController',
        'method' => 'new'
    ],

    'articles' => [
        'path' => '/admin/articles',
        'controller' => 'Admin\\Article\\ArticleController',
        'method' => 'articles'
    ],

    'delete-article' => [
        'path' => '/api/delete-article',
        'controller' => 'API\\ArticleController',
        'method' => 'delete'
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