<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\Get;
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

    public function getOne(): string
    {
        $articleSlug = Get::key('article');

        $articleModel = new ArticleModel();
        $article = $articleModel->findOneBySlug($articleSlug);

        if(!$article)
        {
            return $this->redirect('404');
        }

        $pageTitle = $article->title;

        return $this->render('article', [
            'pageTitle' => $pageTitle,
            'article' => $article
        ]);
    }
}