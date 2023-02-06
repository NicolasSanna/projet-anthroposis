<?php

require '../vendor/autoload.php';

// Inclusion du fichier de configuration
require '../config.php';

// Inclusion des dépendances (fichiers de fonctions)
require PROJECT_DIR . '/library/functions.php';

// On va chercher les routes dans le fichier de configuration routes.php
$routes = require PROJECT_DIR . '/app/routes.php';

// On va chercher la classe du Router.
use App\Framework\Router;

// On utilise la classe Server et sa méthode Path qui permet de retourner le path sans la rupture (?)
use App\Framework\Server;

// On va chercher la classe qui va charger l'application
use App\Framework\Application as App;

// // On appelle la fonction méthode path() pour récupérer le path de la requête HTTP courante.
// $server = new Server();
$path = Server::path();

// Appel du Router pour récupérer le contrôleur à appeler (nom de la classe + nom de la méthode)
$router = new Router($routes);
$action = $router->match($path);

// Démarrage de l'application
App::run($action['controller'], $action['method']);