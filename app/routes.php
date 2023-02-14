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
    
    'articles' => [
        'path' => '/admin/auteur/mes-articles',
        'controller' => 'Admin\\Article\\ArticleController',
        'method' => 'articles'
    ],

    'new-article' => [
        'path' => '/admin/auteur/nouvel-article',
        'controller' => 'Admin\\Article\\ArticleController',
        'method' => 'new'
    ],

    'delete-article' => [
        'path' => '/api/admin/auteur/delete-article',
        'controller' => 'API\\ArticleController',
        'method' => 'delete'
    ],

    'update-article' => [
        'path' => '/admin/auteur/modifier-article',
        'controller' => 'Admin\\Article\\ArticleController',
        'method' => 'update'
    ],

    'new-category' => [
        'path' => '/admin/administrateur/ajouter-une-categorie',
        'controller' => 'Admin\\Category\\CategoryController',
        'method' => 'new'
    ],

    'categories' => [
        'path' => '/admin/administrateur/categories',
        'controller' => 'Admin\\Category\\CategoryController',
        'method' => 'categories'
    ],

    'delete-category-with-articles' => [
        'path' => '/api/admin/administrateur/delete-category-with-articles',
        'controller' => 'API\\CategoryController',
        'method' => 'deleteWithArticles'
    ],

    'delete-category-without-articles' => [
        'path' => '/api/admin/administrateur/delete-category-without-articles',
        'controller' => 'API\\CategoryController',
        'method' => 'deleteWithoutArticles'
    ],

    'update-category' => [
        'path' => '/admin/administrateur/modifier-categorie',
        'controller' => 'Admin\\Category\\CategoryController',
        'method' => 'update'
    ],

    'users' => [
        'path' => '/admin/administrateur/utilisateurs',
        'controller' => 'Admin\\User\\UserController',
        'method' => 'manage'
    ],

    'update-user-to-author' => [
        'path' => '/admin/administrateur/utilisateur-auteur',
        'controller' => 'Admin\\User\\UserController',
        'method' => 'updateToAuthor'
    ],

    'update-user-to-new-user' => [
        'path' => '/admin/administrateur/utilisateur-nouvel-utilisateur',
        'controller' => 'Admin\\User\\UserController',
        'method' => 'updateToNewUser'
    ],

    'manage-users-articles' => [
        'path' => '/admin/administrateur/gerer-utilisateurs-articles',
        'controller' => 'Admin\\Article\\ArticleController',
        'method' => 'usersArticles'
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