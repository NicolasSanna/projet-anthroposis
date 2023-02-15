<?php 

// On indique l'espace de nom : App\Framework (composer.json : src/Framework de l'autoload)
namespace App\Framework;

/**
 * Création de la classe abstraite AbstractModel.
 */
abstract class AbstractModel 
{
    // On créé un objet $database en protégé (par conséquent inaccessible en dehors de cette classe ou de celles qui sont autorisées à l'appeller par le biais de extends);
    protected Database $database;

    /**
     * On créé la méthode protégée construct qui ne prend aucun paramètre. 
     */
    protected function __construct()
    {
        // On on appelle la méthode getInstance() de l'objet Database qui va créer l'objet Database à partir du Singleton. 
        // Inutile de mettre un use /Database car le fichier Database.php est au même niveau que le fichier AbstractModel.php.
        $this->database = Database::getInstance();
    }
}