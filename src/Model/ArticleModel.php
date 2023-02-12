<?php

namespace App\Model;

use App\Framework\AbstractModel;

class ArticleModel extends AbstractModel
{
    private const STATUS_NOT_APPROVED = 1;
    private const STATUS_APPROVED = 2;

    public function __construct()
    {
        parent::__construct();
    }

    public function insert(string $title, string $description, string $content, string $slug, int $userId, int $categoryId, string $image = null): void
    {
        $sql = 'CALL SP_ArticleInsert(:title, :description, :content, :image, :slug, :userId, :categoryId, :statusId)';

        $this->database->executeQuery($sql, [
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'image' => $image,
            'slug' => $slug,
            'userId' => $userId,
            'categoryId' => $categoryId,
            'statusId' => self::STATUS_NOT_APPROVED
        ]);
    }
}