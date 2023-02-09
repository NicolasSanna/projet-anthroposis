<?php

namespace App\Framework;

class Get 
{
    private static array $get;
    private static string $key;

    /**
     * La fonction getCheck vérifie s'il y a quelque chose dans l'URL
     */
    private static function getCheck(): void
    {
       if(!isset($_GET))
        {
            $url = buildUrl('404');

            header('Location: ' . $url);
            exit;
        }

        self::$get = $_GET;
    }

    /**
     * On créé une fonction keyExists qui prend en paramètre la clé du tableau associatif de $_GET[$key].
     */
    private static function keyExists(): void
    {
        self::getCheck();
    
        // Si une clé existe dans l'URL, et que cette clé est déclarée dans l'URL.
        if (!array_key_exists(self::$key, self::$get) || !self::$get[self::$key])
        {
            $url = buildUrl('404');

            // La redirection qui se fait avec la fonction header('Location:) est concaténée à la variable $url. Et l'on sort. 
            header('Location: ' . $url);
            exit;
        }
    }

    private static function getEmptyKey(): void
    {
        self::keyExists();

        if(empty(self::$get[self::$key]) || str_contains(self::$get[self::$key], '<script>'))
        {
            $url = buildUrl('404');

            // La redirection qui se fait avec la fonction header('Location:) est concaténée à la variable $url. Et l'on sort. 
            header('Location: ' . $url);
            exit;
        }
    }

    /**
     * Création de la fonction statique key, elle permet de contrôller qu'un paramètre donné en GET n'est pas interprété.
     */
    public static function key(string $key): string
    {
        self::$key = $key;
        self::getEmptyKey();

        $get = htmlspecialchars(self::$get[self::$key]);

        return $get;
    }
}