<?php

namespace App\Framework;

use \InvalidArgumentException;
use \RuntimeException;

/**
 * Classe de chargement du fichier .env
 */
class DotEnv
{
    // Le chemin où se trouve le fichier .env
    private string $path;

    public function __construct(string $path)
    {
        if(!file_exists($path)) 
        {
            throw new InvalidArgumentException(sprintf('Le fichier %s n\'existe pas.', $path));
        }
        $this->path = $path;
    }

    /**
     * Ajout à la superglobale $_ENV des informations du fichier .env
     */
    public function load(): void
    {
        if (!is_readable($this->path)) 
        {
            throw new RuntimeException(sprintf('Le fichier %s n\'est pas lisible.', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) 
        {

            if (strpos(trim($line), '#') === 0) 
            {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) 
            {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}