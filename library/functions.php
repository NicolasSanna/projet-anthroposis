<?php

/**
 * La fonction asset permet de faire appel aux différents fichiers venant des dossiers du dossier public : css, js, img,... Elle prend en paramètre le chemin à partir de l'index.php.
 */
function asset(string $path): string 
{
    return SITE_BASE_URL . '/' . $path;
}

/**
 * La fonction buildUrl prend en paramètre le nom de la route venant du tableau de routes de routes.php, en second paramètre, elle peut recevoir des éléments GET.
 */
function buildUrl(string $routeName, array $params = []): string
{
    // Si la clé route venant de la constante ROUTES n'existe pas on retourne faux.
    if (!array_key_exists($routeName, ROUTES)) 
    {
        return false;
    }

    // L'URL définie vient du path du nom de la route du tableau associatif de la constante ROUTES.
    $url = ROUTES[$routeName]['path'];

    // S'il y a des paramètres, (des $_GET dans l'URL notamment)
    if ($params) 
    {
        // On concatène à l'URL le point d'interrogation qui est le séparateur en PHP permettant l'entrée de paramètres, et l'on construit l'adresse complète avec les paramètres ($_GET, et autres)
        $url .= '?' . http_build_query($params);
    }

    return $url;
}

/**
 * La fonction slugify prend en paramètre une chaîne de caractères permettant de créer des URLs lisibles.
 */
function slugify (string $string, string $delimiter = '-'): string
{
	$oldLocale = setlocale(LC_ALL, '0');
	setlocale(LC_ALL, 'en_US.UTF-8');
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower($clean);
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	$clean = trim($clean, $delimiter);
	setlocale(LC_ALL, $oldLocale);
	return $clean;
}

/**
 * La fonction verifyContent se charge de retirer les chaînes vides et de poser la sécurité contre la faille XSS avec la fonction htmlspecialchars.
 */
function verifyContent(string $string): string
{
    $secureString = trim(htmlspecialchars($string, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8'));

    return $secureString;
}
