<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\Get;
use App\Framework\Post;
use App\Model\ArticleModel;
use App\Model\CategoryModel;

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

    public function getAll(): string
    {
        $pageTitle = 'Tous les articles';

        $articleModel = new ArticleModel();
        $articles = $articleModel->findAll();

        return $this->render('articles', [
            'pageTitle' => $pageTitle,
            'articles' => $articles
        ]);
    }

    public function getAllByCategory(): string
    {
        $categorySlug = Get::key('categorie');

        $categoryModel = new ArticleModel();
        $articles = $categoryModel->findAllByCategory($categorySlug);
        
        if(!$articles)
        {
            FlashBag::addFlash('Aucun article n\'existe pour le moment dans cette catégorie', 'error');
            return $this->redirect('categories');
        }

        $categoryName = $articles[0]->category_name;
        $pageTitle = 'Articles de la catégorie ' . $categoryName;

        return $this->render('category', [
            'pageTitle' => $pageTitle,
            'articles' => $articles,
            'categoryName' => $categoryName
        ]);
    }
}