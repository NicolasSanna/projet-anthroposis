<?php

namespace App\Framework;

abstract class AbstractEntity
{
    protected Database $database;

    protected function __construct()
    {
        $this->database = Database::getInstance();
    }
}