<?php

namespace App\Framework;

class Application
{
    public static function run(string $className, string $method): void
    {
        $className = 'App\\Controller\\' . $className;
        $controller = new $className();
        $start = $controller->$method();

        echo $start;
    }
}