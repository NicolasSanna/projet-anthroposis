<?php

namespace App\Framework;

/**
 * Classe de gestion des événements sur $_SERVER.
 */
class Server 
{
    // Propriété $path.
    private static string $path;

    public static function path (): string
    {
        // On stocke dans la variable $fullPath la totalité de l'adresse (requête) HTTP du navigateur. Si elle est null, on met à la place le / qui désigne l'entrée du site (pas d'éléments supplémentaires dans l'adresse).
        $fullPath = htmlspecialchars($_SERVER['REQUEST_URI']) ?? '/';

        // Avec la fonction explode, on désigne le point de rupture, (le ? de PHP qui indique un paramètre dans l'URL de type $_GET). en second paramètre on indique quelle partie de l'URL explosée on souhaite récupérer, ici, la partie avant le point d'interrogation pour trouver le bon contrôleur. [0] case avant le ?, [1] après le ?. Car c'est un tableau.
        self::$path = explode('?', $fullPath)[0];

        if(!self::secureAdmin())
        {
            $url = buildUrl('403');
            header('Location:' .  $url);
            exit;
        }

        self::$path = self::secureApi();

        // Renvoie du path
        return self::$path;
    }

    /**
     * Méthode permettant de protéger toutes les routes de personnes qui doivent être connectées.
     */
    private static function secureAdmin(): bool
    {
        UserSession::timeout();

        // si le path contient '/admin', et que la personne qui tente d'y accéder n'est pas connectée...
        if (str_contains(self::$path, '/admin') && !UserSession::isAuthenticated())
        {
            // On renvoie False.
            return false;
        }

        if (str_contains(self::$path, '/admin/auteur'))
        {
            if(UserSession::isAdmin() || UserSession::isAuthor())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        if (str_contains(self::$path, '/admin/administrateur'))
        {
            if(!UserSession::isAdmin())
            {
                return false;
            }
        }

        // Sinon, on renvoie true.
        return true;
    }

    /**
     * Méthode privée afin de vérifier que le path ne contient pas /api qui correspond à des routes asynchrones du JavaScript vers le PHP et renvoie des informations.
     */
    private static function secureApi()
    {
        // Si le path contient /api, et que la clé de la superglobale $_SERVER['HTTP_X_REQUESTED_WITH'] n'est pas vide et contient en minuscules xmlhttprequest ...
        if(str_contains(self::$path, '/api') && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        {
            // On renvoie le path tel qu'il est.
            return self::$path;
        }

        // Si le path ne contient pas /api, et correspond à une route publique normale 
        if(!str_contains(self::$path, '/api'))
        {
            // On renvoie le path tel qu'il est.
            return self::$path;
        }

        //  Si le path contient /api, mais que la  clé de la superglobale $_SERVER['HTTP_X_REQUESTED_WITH'] est vide ou bien différente de la chaîne de caractères xmlhttprequest...
        if(str_contains(self::$path, '/api') && empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
        {
            // Alors on redéfinit le path vers la route 403.
            $url = buildUrl('403');
            header('Location:' .  $url);
        }
    }
}