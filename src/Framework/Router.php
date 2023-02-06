<?php 

namespace App\Framework;

/**
 * Création de la classe Router.
 */
class Router 
{

    // Stocke le tableau de routes
    private array $routes;

    /**
     * Constructeur
     */
    public function __construct(array $routes)
    {
        // Initialise la propriété $routes 
        $this->routes = $routes;
    }

    /**
     * Retourne le controller (nom de la classe et de la méthode) correspondant au path
     */
    public function match(string $path): array
    {
        // On parcours le tableau de routes stocké dans la propriété 'routes' de l'objet courant ($this)
        foreach ($this->routes as $route) 
        {

            // Si le chemin de la route correspond à celui que l'on cherche... 
            if ($path === $route['path']) 
            {

                // On a trouvé notre route ! On retourne le nom de la classe de contrôleur et la méthode associés
                return [
                    'controller' => $route['controller'],
                    'method' => $route['method']
                ];
            }
        }

        // Si on arrive ici on n'a pas trouvé la route, on renvoie le controller et sa méthode chargée de la page 404.
        return [
            'controller' => 'HomeController',
            'method' => 'notFound'
        ];
    }
}