<?php

namespace App\Model;

use App\Framework\AbstractModel;

class CategoryModel extends AbstractModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): mixed
    {
        $sql = 'CALL SP_CategoryAllSelect()';

        $results = $this->database->getAllResults($sql);

        return $results;
    }
}