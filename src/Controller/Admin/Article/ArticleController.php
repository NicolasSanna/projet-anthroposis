<?php

namespace App\Controller\Admin\Article;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\Get;
use App\Framework\Image;
use App\Framework\Post;
use App\Framework\UserSession;
use App\Model\ArticleModel;
use App\Model\CategoryModel;

class ArticleController extends AbstractController
{
    public function new(): string
    {
        $pageTitle = 'Nouvel article';
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        $token = UserSession::token();
        $userId = UserSession::getId();

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();

            $title = $post['title'];
            $description = $post['description'];
            $content = $post['content'];
            $selectedCategory = (int) $post['selectCategory'];
            $checkToken = $post['checkToken'];
            $image = $_FILES['image'];
            $fileName = '';

            if(!$title || !$description || !$content || !$selectedCategory)
            {
                FlashBag::addFlash('Tous les champs n\'ont pas été remplis', 'error');
            }

            if($checkToken != $token)
            {
                FlashBag::addFlash('Le token de session ne correspond pas à celui du formulaire', 'error');
            }

            if(!empty($image['name']))
            {                                    
                $fileModel = new Image($image);
                $fileName = $fileModel->uploadFileImage();
            }

            if(!FlashBag::hasMessages('error'))
            {
                $slugifyTitle = slugify($title) . '-' . (time()+ rand(1,1000));
                $articleModel = new ArticleModel();
                $articleModel->insert($title, $description, $content, $slugifyTitle, $userId, $selectedCategory, $fileName);

                FlashBag::addFlash('Votre article a bien été ajouté, il sera validé prochainement');
                return $this->redirect('dashboard');
            }
        }

        return $this->renderAdmin('admin/article/new', [
            'pageTitle' => $pageTitle,
            'title' => $title??'',
            'description' => $description??'',
            'content' => $content ??'',
            'categories' => $categories,
            'selectedCategory' => $selectedCategory??null,
            'token' => $token
        ]);
    }

    public function articles(): string
    {
        $pageTitle = 'Mes articles';

        $userId = UserSession::getId();
        $token = UserSession::token();

        $articleModel = new ArticleModel();
        $articles = $articleModel->findAllByUser($userId);

        return $this->renderAdmin('admin/article/articles', [
            'pageTitle' => $pageTitle,
            'articles' => $articles,
            'token' => $token
        ]);
    }

    public function update(): string
    {
        $pageTitle = 'Modifier mon article';

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        $token = UserSession::token();
        $userId = UserSession::getId();
        $articleSlug = Get::key('article');

        $articleModel = new ArticleModel();
        $article = $articleModel->findOneByUser($userId, $articleSlug);

        if(!$article)
        {
            FlashBag::addFlash('Cet article n\'existe pas', 'error');
            return $this->redirect('404');
        }

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();

            $title = $post['title'];
            $description = $post['description'];
            $content = $post['content'];
            $selectedCategory = (int) $post['selectCategory'];
            $checkToken = $post['checkToken'];
            $image = $_FILES['image'];
            $fileName = '';

            if(!$title || !$description || !$content || !$selectedCategory)
            {
                FlashBag::addFlash('Tous les champs n\'ont pas été remplis', 'error');
            }

            if($checkToken != $token)
            {
                FlashBag::addFlash('Le token de session ne correspond pas à celui du formulaire', 'error');
            }

            if(!empty($image['name']))
            {                                    
                $fileModel = new Image($image, $article->image);
                $fileName = $fileModel->uploadFileImage();
            }

            if(!FlashBag::hasMessages('error'))
            {
                $slugifyTitle = slugify($title);
                $articleModel = new ArticleModel();
                $articleModel->update($title, $description, $content, $slugifyTitle, $userId, $selectedCategory, $article->idArt, $fileName);

                FlashBag::addFlash('Votre article a bien été modifié, il sera validé prochainement');
                return $this->redirect('dashboard');
            }
        }

        return $this->renderAdmin('admin/article/update', [
            'pageTitle' => $pageTitle,
            'article' => $article,
            'title' => $title??$article->title,
            'description' => $description??$article->description,
            'content' =>  $content??$article->content,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory??$article->category_id,
            'token' => $token
        ]);
    }

    public function usersArticles()
    {
        $pageTitle = 'Gérer les articles des utilisateurs';

        $articleModel = new ArticleModel();
        $articles = $articleModel->usersArticles();

        return $this->renderAdmin('admin/article/users-articles', [
            'pageTitle' => $pageTitle,
            'articles' => $articles
        ]);
    }
}