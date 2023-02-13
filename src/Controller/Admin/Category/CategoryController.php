<?php

namespace App\Controller\Admin\Category;

use App\Framework\Get;
use App\Framework\Post;
use App\Framework\FlashBag;
use App\Model\CategoryModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class CategoryController extends AbstractController
{
    public function new(): string
    {
        $pageTitle = 'Ajouter une catégorie';
        $token = UserSession::token();

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();

            $category = $post['category'];
            $checkToken = $post['checkToken'];

            if(!$category)
            {
                FlashBag::addFlash('Le champ est vide', 'error');
            }

            if($checkToken != $token)
            {
                FlashBag::addFlash('Le token de session ne correspond pas à celui du formulaire', 'error');
            }

            if(!FlashBag::hasMessages('error'))
            {
                $slugCategory = slugify($category);

                $categoryModel = new CategoryModel();
                $result = $categoryModel->insert($category, $slugCategory);

                FlashBag::addFlash($result->message, 'query');
            }
        }

        return $this->renderAdmin('admin/category/new', [
            'pageTitle' => $pageTitle,
            'category' => $category??'',
            'token' => $token
        ]);
    }

    public function categories (): string
    {
        $pageTitle = 'Gérer les catégories';
        $token = UserSession::token();

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        return $this->renderAdmin('admin/category/categories', [
            'pageTitle' => $pageTitle,
            'categories' => $categories,
            'token' => $token
        ]);
    }

    public function update(): string
    {
        
        $token = UserSession::token();
        $categorySlug = Get::key('categorie');

        $categoryModel = new CategoryModel();
        $category = $categoryModel->findOneBySlug($categorySlug);

        if(!$category)
        {
            FlashBag::addFlash('La catégorie n\'existe pas', 'error');
            return $this->redirect('404');
        }

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();
            $checkToken = $post['checkToken'];

            $updateCategory = $post['category'];
            
            if($checkToken != $token)
            {
                FlashBag::addFlash('Le token de session ne correspond pas à celui du formulaire', 'error');
            }

            if(!$updateCategory)
            {
                FlashBag::addFlash('Le champ est vide', 'error');
            }

            if(!FlashBag::hasMessages('error'))
            {
                $slugCategory = slugify($updateCategory);
                $result = $categoryModel->update($category->idCat, $updateCategory, $slugCategory);

                FlashBag::addFlash($result->message, 'query');
            }
        }

        return $this->renderAdmin('admin/category/update', [
            'categoryName' => $updateCategory??$category->category_name,
            'category' => $category,
            'token' => $token
        ]);
    }
}