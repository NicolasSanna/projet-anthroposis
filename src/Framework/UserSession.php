<?php 

// On indique l'espace de nom : App\Framework (composer.json : src/Framework).
namespace App\Framework;

/**
 * On créé la classe UserSession.
 */
class UserSession extends AbstractSession
{
    private const ROLE_ADMINISTRATOR_STRING = "['ROLE_ADMINISTRATOR']";
    private const ROLE_AUTHOR_STRING = "['ROLE_AUTHOR']";
    private const ROLE_NEW_USER_STRING = "['ROLE_NEW_USER']";

    private const ROLE_ADMINISTRATOR_ID = 1;
    private const ROLE_AUTHOR_ID = 2;
    private const ROLE_NEW_USER_ID = 3;

    /**
     * Enregistre les informations de l'utilisateur en session venant du formulaire de connexion et avec les informations relatives venant de la base de données.
     */
    public static function register(int $userId, string $firstname, string $lastname, string $pseudo, string $email, string $roleLabel, int $roleId, ): void
    {

        // On s'assure que la session est bien démarrée en appelant la méthode sessionCheck(). C'est une méthode statique héritée de l'AbstractSession : pas besoin d'instancier le constructeur parent.
        self::sessionCheck();
        
        // On créé une clé User dans la superglobal $_SESSION qui est un tableau associatif contenant les diverses informations relatives à l'utilisation qui s'est connecté.
        $_SESSION['user'] = [
            'userId' => $userId,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pseudo' => $pseudo,
            'email' => $email,
            'roleLabel' => $roleLabel,
            'roleId' => $roleId,
        ];

        // On appelle la méthode privée token afin de générer le token aléatoire lors de la connexion de l'utilisateur.
        self::token();
    }

    /**
     * On créé une méthode statique is authenticated.
     */
    public static function isAuthenticated(): bool
    {
        // On s'assure que la session est bien démarrée en appelant la méthode sessionCheck().
        self::sessionCheck();

        if(array_key_exists('user', $_SESSION) && isset($_SESSION['user']) && !is_null($_SESSION['user']))
        {
            return true;
        }

        return false;
    }

    /**
     * On créé une méthode statique logout.
     */
    public static function logout(): void
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne.
        if (!self::isAuthenticated())
        {
            return;
        }

        // Sinon, on met la clé 'user' à null, et on vide la session.
        $_SESSION['user'] = null;
        session_destroy();
    }

    /**
     * On créé une méthode statique getId.
     */
    public static function getId(): int
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }

        // Sinon on retourne l'identifiant userId venant de la clé user de la superlogable $_SESSION.
        return $_SESSION['user']['userId'];
    }

    /**
     * On créé une méthode statique getFirstname()
     */
    public static function getFirstname(): string
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }
        // Sinon on retourne l'identifiant firstname venant de la clé user de la superlogable $_SESSION.
        return $_SESSION['user']['firstname'];
    }

    /**
     * On créé une méthode statique getFirstname()
     */
    public static function getLastname(): string
    {
         // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }
        // Sinon on retourne l'identifiant lastname venant de la clé user de la superlogable $_SESSION.
        return $_SESSION['user']['lastname'];
    }

    /**
     * Retourne le nom complet de l'utilisateur connecté
     */
    public static function getFullname(): string
    {
        if (!self::isAuthenticated())
        {
            return null;
        }

        return $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];
    }

    /**
     * On créé une méthode statique getFirstname()
     */
    public static function getEmail(): string
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }

        // Sinon on retourne l'identifiant email venant de la clé user de la superlogable $_SESSION.
        return $_SESSION['user']['email'];
    }

    /**
     * On créé une fonction statique token().
     */
    public static function token(): string
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }
     
        // Si $_SESSION['user']['token'] n'est pas déclarée...
        if(!isset($_SESSION['user']['token']))
        {
            // On créé la clé token dans user dans $_SESSION et qui reçoit une chaîne de caractères composées de chiffres et de lettres aléatoires et qui change à chaque connexion.
            $_SESSION['user']['token'] = bin2hex(openssl_random_pseudo_bytes(24));
        }

        // On retourne le token.
        return $_SESSION['user']['token'];
    }
}