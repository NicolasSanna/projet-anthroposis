<?php

namespace App\Framework;

class Post
{
    // On déclare une propriété privée qui est un tableau qui contiendra le tableau associatif $_POST.
    private static array $post;

    /**
     * Méthode statique check qui permet de vérifier si $_POST est déclaré et n'est pas vide.
     */
    public static function checkIsPost(): bool
    {
        if(isset($_POST) && !empty($_POST))
        {
            self::$post = $_POST;
            return true;
        }

        return false;
    }

    public static function checkerForm(): array
    {
        self::checkIsPost();

        $post = array_map('verifyContent', self::$post);

        return $post;
    }
}