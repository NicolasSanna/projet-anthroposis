<?php 

// Configuration des chemins vers les répertoires
define('PROJECT_DIR', __DIR__);
define('TEMPLATE_DIR', PROJECT_DIR . '/templates');
define('PUBLIC_DIR', PROJECT_DIR . '/public');
define ('IMAGE_DIR', PROJECT_DIR . '/public/img/imgArticle');

// Chargement des informations du fichier .env
$dotEnv = new App\Framework\DotEnv(PROJECT_DIR . '/.env');
$dotEnv->load();

// En local :
// Attention, changer le SITE_BASE_URL en cas de mise en ligne, et décommenter le .htaccess.
define('SITE_BASE_URL', getenv('SITE_BASE_URL'));

define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));

define('DB_MS', getenv('DB_MS'));
define('DB_PORT', getenv('DB_PORT'));
define('DB_CHARSET', getenv('DB_CHARSET'));

define('EMAIL_FROM', getenv('EMAIL_FROM'));
define('EMAIL_TO', getenv('EMAIL_TO'));

// Gestion de l'affichage des erreurs côté PHP.
// En développement :
error_reporting(-1);
ini_set('display_errors', 1);

// En production:
// error_reporting(0);
// ini_set('display_errors', 0);