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

    public function insert(string $category, string $categorySlug): mixed
    {   
        $sql = 'CALL SP_CategoryInsert(:category, :categorySlug)';

        $result = $this->database->getOneResult($sql, [
            'category' => $category,
            'categorySlug' => $categorySlug
        ]);

        return $result;
    }

    public function deleteWithArticles(int $categoryId): void
    {
        $sql = 'CALL SP_CategoryWithArticlesDelete(:categoryId)';

        $this->database->executeQuery($sql, [
            'categoryId' => $categoryId
        ]);
    }

    public function deleteWithoutArticles(int $categoryId): void
    {
        $sql = 'CALL SP_CategoryWithoutArticlesDelete(:categoryId)';

        $this->database->executeQuery($sql, [
            'categoryId' => $categoryId
        ]);
    }

    public function findOneBySlug(string $categorySlug): mixed
    {
        $sql = 'CALL SP_CategorySelect(:categorySlug)';

        $result = $this->database->getOneResult($sql, [
            'categorySlug' => $categorySlug
        ]);

        return $result;
    }

    public function update(int $categoryId, string $category, string $categorySlug): mixed
    {
        $sql = 'CALL SP_CategoryUpdate(:categoryId, :category, :categorySlug)';

        $result = $this->database->getOneResult($sql, [
            'categoryId' => $categoryId,
            'category' => $category,
            'categorySlug' => $categorySlug
        ]);

        return $result;
    }
}