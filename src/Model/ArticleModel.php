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

    public function findAllByUser(int $userId): array
    {
        $sql = 'CALL SP_ArticleUserAllSelect(:userId)';

        $results = $this->database->getAllResults($sql, [
            'userId' => $userId
        ]);

        return $results;
    }

    public function delete (int $userId, string $articleSlug): mixed
    {
        $article = $this->findOneByUser($userId, $articleSlug);

        $sql = 'CALL SP_ArticleDelete(:userId, :articleSlug)';

        $this->database->executeQuery($sql, [
            'userId' => $userId,
            'articleSlug' => $articleSlug
        ]);

        return $article;
    }

    public function findOneByUser(int $userId, string $articleSlug): mixed
    {
        $sql = 'CALL SP_ArticleUserOneSelect(:userId, :articleSlug)';
        
        $result = $this->database->getOneResult($sql, [
            'userId' => $userId,
            'articleSlug' => $articleSlug
        ]);

        return $result;
    }

    public function update(string $title, string $description, string $content, string $slug, int $userId, int $categoryId, int $articleId, string $image = null): void
    {
        $sql = 'CALL SP_ArticleUpdate(:title, :description, :content, :image, :slug, :userId, :categoryId, :statusId, :articleId)';

        $this->database->executeQuery($sql, [
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'image' => $image,
            'slug' => $slug,
            'userId' => $userId,
            'categoryId' => $categoryId,
            'statusId' => self::STATUS_NOT_APPROVED,
            'articleId' => $articleId
        ]);
    }

    public function usersArticles (): array
    {
        $sql = 'CALL SP_UsersArticlesManageSelect(:statusId)';

        $results = $this->database->getAllResults($sql, [
            'statusId' => self::STATUS_NOT_APPROVED
        ]);

        return $results;
    }

    public function findOneBySlug(string $articleSlug): mixed
    {
        $sql = 'CALL SP_ArticleSelect(:articleSlug)';

        $result = $this->database->getOneResult($sql, [
            'articleSlug' => $articleSlug
        ]);

        return $result;
    }

    public function approbe(string $articleSlug): void
    {
        $sql = 'CALL SP_ArticleManageUpdate(:articleSlug, :statusId)';

        $this->database->executeQuery($sql, [
            'articleSlug' => $articleSlug,
            'statusId' => self::STATUS_APPROVED
        ]);
    }

    public function searchArticle (string $search): array
    {
        $sql = 'CALL SP_SearchArticleSelect(:search, :statusId)';

        $results = $this->database->getAllResults($sql, [
            'search' => $search,
            'statusId' => self::STATUS_APPROVED
        ]);

        return $results;
    }
}