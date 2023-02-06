<?php 

// On indique l'espace de nom : App\Framewok (composer.json : src/Framework). 
namespace App\Framework;

// On indique que l'on va se servir des objets PDO et PDOStatement afin d'effectuer la connexion à la base de données.
use \PDO;
use \PDOStatement;
use \PDOException;
use \Exception;

/**
 * // On créé la classe Database. 
 */
class Database 
{
    // On définit une propriété privée $pdo dont le type est PDO.
    private PDO $pdo;

    // On définit une propriété privée statique qui peut être null ou objet $_instance dont on affecte la valeur null.
    private static ?self $_instance = null;

    // Création de la méthode privée __construct(). A l'instanciation de la classe, cela lancera la méthode getPdoConnection.
    private function __construct()
    {
        $this->pdo = $this->getPdoConnection();
    }

    // Création d'une méthode statique public getInstance. C'est la méthode qui va créer una classe une seule fois (Singleton).
    public static function getInstance(): self
    {
        // Si $_instance est null...
        if(is_null(self::$_instance))
        {
            // On affecte à la variable $_instance une nouvelle instance de l'objet lui-même : Database.
            self::$_instance = new self();
        }

        // On retourne l'objet Database.
        return self::$_instance;
    }

    /**
     * On créé la fonction getPdoConnexion() qui est un objet PDO. PHP Datas Objects. (Objets de données PHP)
     */
    private function getPdoConnection(): PDO
    {
        // Dans le DSN (Data Source Name), on indique les différents paramètres de la connexion à la base de données. On se set des constantes du config.php afin de donner les paramètres :
        /**
         * - Le SGBDR :(Système de Gestion de Base de Données Relationnelles) ou DB_MS (DataBase Management System). Ici MySQL.
         * - L'hôte : le serveur sur lequel se connecter. Ici le LocalHost.
         * - Le port : celui par lequel MySQL peut se connecter au serveur. Ici, le 3306.
         * - Le nom de la base de données à sa création.
         * - Le jeu de caractères. A préciser sinon les données ne s'afficheront pas correctement et notamment les caractères spéciaux : &éèà@ù...
         */

        $dsn = ''.DB_MS.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET.'';

        // On met dans la variable $pdo les différents paramètres nécessaires en plus du DSN :
        /**
         * On créé d'abord le nouvel objet PDO qui prend en paramètre le DSN, le nom de l'utilisateur de la base de données défini dans le config.php, le mot de passe, et enfin un tableau associatif définissant les paramètres de PDO :
         * - PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC : Spécifie que la méthode d'extraction doit renvoyer chaque ligne sous la forme d'un tableau indexé par nom de colonne tel qu'il est renvoyé dans l'ensemble de résultats correspondant. Si le jeu de résultats contient plusieurs colonnes portant le même nom, PDO::FETCH_ASSOCrenvoie une seule valeur par nom de colonne.
         * - PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION : Lance une PDO EXCEPTION si une erreur se produit.
         * - PDO::ATTR_EMULATE_PREPARES => false : On n'émule pas les requêtes à partir de MySQL.
         */

        $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

        // On essaie de se connecter à PDO.
        try 
        {
            $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        }
        catch (Exception $e)
        {
            throw new Exception (sprintf("Une erreur est survenue : %s", $e->getMessage()));
        }

        // On lance la transaction et l'on commit toutes les requêtes SQL si tout s'est bien passé. Sinon, on capture l'erreur, et l'on rétabli la base de données à son état précédent le lancement de la transaction.
        try
        {
            $pdo->beginTransaction();
            $pdo->commit();
        }
        catch (PDOException $error)
        {
            $pdo->rollBack();
            throw new Exception (sprintf("Une erreur est survenue : %s", $error->getMessage()));
        }

        // On retourne l'objet PDO.
        return $pdo;
    }

    /**
     * Création de la méthode executeQuery qui prend en paramètre une chaîne de caractère représentant la requête SQL et un tableau de paramètre erprésentants les données à recevoir et exécuter.
     */
    public function executeQuery(string $sql, array $params = []): false|PDOStatement
    {
        // On créé la variable $pdoStatement qui reçoit la variable $this->pdo, qui prépare la requête SQL qu'elle prend en paramètre. La méthode prepare() et execute() permet de distinguer la requête SQL d'un côté, avec des paramètres anonymes (?, ou :variable).
        $pdoStatement = $this->pdo->prepare($sql);
        
        // Puis, on execute les différents paramètres reçus pour réaliser la requête SQL cette fois ci avec les variables contenant les différentes données à exécuter.
        $pdoStatement->execute($params);

        // On renvoie $pdoStatement. 
        return $pdoStatement;
    }

    /**
     * On créé la méthode getOneResult qui prend en paramètre une chaîne de caractères représentant la requête SQL à exécuter, et un tableau de paramètres à insérer grâce à la reuqête SQL.
     */
    public function getOneResult(string $sql, array $params = []): mixed
    {
        // la variable $pdoStatement reçoit la méthode executeQuery ayant en paramètre la requête SQL et les paramètres reçus.
        $pdoStatement = $this->executeQuery($sql, $params);

        // Le résultat de la requête SQL réalisée dans $pdoStatement grâce à la méthode fetch est récupéré dans $result.
        $result = $pdoStatement->fetch();

        // On retourne le resultat.
        return $result;
    }

    /**
     * On créé la méthode getAllResults qui reçoit en paramètre une chaîne de caractère qui est la requête SQL et les paramètres à exécuter dans la requête SQL.
     */
    public function getAllResults(string $sql, array $params = []): array
    {
        // On range dans $pdoStatement la méthode exécuteQuery avec les paramètres de la requête SQL et des données.
        $pdoStatement = $this->executeQuery($sql, $params);

        // On récupère la totalité des résultats dans $result grâce à la méthode fetchAll.
        $results = $pdoStatement->fetchAll();

        // On retourne les résultats.
        return $results;
    }

    /**
     * On créé une méthode insert() qui reçoit en paramètre la chaîne de caractères représentant la requête SQL, puis les données en paramètres. 
     */
    public function insert(string $sql, array $params = []): string
    {
        // On prépare la requête SQL en donnant en paramètre la chaîne de caractères dans la méthode prépare.
        $pdoStatement = $this->pdo->prepare($sql);

        // On éxécute la requête SQL avec les paramètres.
        $pdoStatement->execute($params);
        
        // Grâce à la fonction lastInsertId() on peut récupérer la ligne de la dernière entrée réalisée dans la table de la base de données.
        $lastInsertId = $this->pdo->lastInsertId();

        // On retourne le résultat de $lastInsertId.
        return $lastInsertId;
    }
}