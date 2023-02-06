<?php

namespace App\Framework;

class Autoloader 
{
    public static function register(): void
    {
        spl_autoload_register([__CLASS__, 'autoload']); 
    }

    private static function autoload(string $className): void
    {
        $className = str_replace('App\\', PROJECT_DIR . '/src/', $className);
        $className = str_replace('\\', '/', $className);
        require ''.$className.'.php';
    }
}