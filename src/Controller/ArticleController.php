<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\Post;
use App\Model\ArticleModel;

class ArticleController extends AbstractController
{
    public function searchArticle(): string
    {
        $pageTitle = 'Rechercher un article';

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();
            $search = $post['search'];
            $articleModel = new ArticleModel();
            $results = $articleModel->searchArticle($search);

            foreach ($results as $index => $result)
            {
                $results[$index]->articleUrl = SITE_BASE_URL . buildUrl('article', ['article' => $result->article_slug]);
                $results[$index]->categoryUrl = SITE_BASE_URL . buildUrl('category', ['categorie' => $result->category_slug]);
            }

            return json_encode($results);
        }

        return $this->render('search-article', [
            'pageTitle' => $pageTitle
        ]);
    }
}