<?php 

// On indique l'espace de noms : App\Framework (composer.json autoload : src/Framework)
namespace App\Framework;

/**
 * On créé la classe FlashBag. Elle hérite de AbstractSession
 */
class FlashBag extends AbstractSession
{
    /**
     * On créé une méthode privé qui initie dans $_SESSION la clé flash.
     */
    private static function initFlashBag(string $type): void
    {

        // On s'assure que la session est bien démarrée en appelant la méthode sessionCheck(). C'est une méthode statique héritée de l'AbstractSession : pas besoin d'instancier le constructeur parent.
        self::sessionCheck();
        
        // Si la clé flash dans la superglobale $_SESSION n'existe pas ou si est nulle...
        if (!array_key_exists('flash', $_SESSION) || is_null($_SESSION['flash'])) 
        {
            // ... Alors on rentre un table dans la clé flash de $_SESSION.
            $_SESSION['flash'] = [];
        }
        
        // Si la clé du type dans la clé flash de $_SESSION n'existe pas, ou si est nul le type...
        if (!array_key_exists($type, $_SESSION['flash']) || is_null($_SESSION['flash'][$type])) 
        {
            // ... Alors on créé un tableau dans le type de la clé flash du tableau associatif de la superglobale $_SESSION.
            $_SESSION['flash'][$type] = [];
        }
    }
    
    /**
     * On créé la méthode statique addFlash. Elle reçoit en paramètre le message rédigé d'une part, par le type de message. Par défaut, c'est le type success.
     */
    public static function addFlash(string $message, string $type = 'success'): void
    {
        // On appelle d'abord la méthode initFlashBag avec en paramètre le type de message.
        self::initFlashBag($type);

        // On place dans le tableau de type dans la clé flash de la superglobale $_SESSION le message.
        $_SESSION['flash'][$type][] = htmlspecialchars($message);
    }
    
    /**
     * On créé une méthode fetchMessages avec le type en paramètre.
     */
    public static function fetchMessages(string $type): array
    {
        // On appelle la méthode initFlashBag avec en paramètre le type de messages.
        self::initFlashBag($type);

        // On range dans $messages les messages venant du type de message du tableau de type, au sein de la clé flash de la superglobale $_SESSION.
        $messages = $_SESSION['flash'][$type];

        // On met les messages du type de message de la clé flash de la superglobale $_SESSION à null afin de vider les messages.
        $_SESSION['flash'][$type] = null;

        // Enfin on renvoie les messages.
        return $messages;
    }
    
    /**
     * On créé une méthode hasMessages qui reçoit en paramètre le type de messages.
     */
    public static function hasMessages(string $type): int
    {
        // On s'assure de faire appel à initFlashBag avec en paramètre le type de message.
        self::initFlashBag($type);

        // On retourne le nombre d'entrées avec la fonction count de messages venant d'un type défini dans la clé flash de la superglobale $_SESSION.
        return count($_SESSION['flash'][$type]);
    }
}