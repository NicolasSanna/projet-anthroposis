<?php 

// Indication de l'espace de nom App\Framework (composer.json : src/Framework)
namespace App\Framework;

/**
 * Création de la classe abstraite AbstractController, classe qui ne s'instancie pas. 
 */
abstract class AbstractController 
{
    /**
     * Création de la méthode publique render. Elle prend en paramètre le nom du template .phtml et en second paramètre d'éventuelles données à afficher sur le templates.
     */
    protected function render(string $template, array $data = []): string
    {
        // On extrait les données.
        extract($data);
    
        // On démarre le tampon de sortie. 
        ob_start();
    
        // On inclue le base.phtml à partir de la constante TEMPLATE_DIR, le base.phtml recevra le template à afficher.
        require TEMPLATE_DIR . '/base.phtml';
    
        // On vide le tampon de sortie.
        return ob_get_clean();
    }

    /**
     * On créé la méthode redirect qui prend en paramètre le nom de la route et d'éventuels paramètres.
     */
    protected function redirect(string $routename, array $params = []): void
    {
        // La fonction redirect se sert de la fonction buildUrl et des paramètres reçus (données). 
        $url = buildUrl($routename, $params);

        // La redirection qui se fait avec la fonction header('Location:) est concaténée à la variable $url. Et l'on sort. 
        header('Location: ' . $url);
        exit;
    }
}