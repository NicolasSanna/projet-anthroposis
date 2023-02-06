<?php 

namespace App\Framework;

/**
 * Création de la classe abstraite AbstractSession. Elle démarre la session et elle peut être héritable pour la classe FlashBag et UserSession
 */
abstract class AbstractSession 
{
    /**
    * Démarre une session si aucune session n'est démarrée
    */
    protected static function sessionCheck(): void
    {
        if (session_status() == PHP_SESSION_NONE) 
        {
            session_start();
        }
    }
}