<?php

namespace App\Controller\Admin\Category;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\Post;
use App\Model\CategoryModel;

class CategoryController extends AbstractController
{
    public function new(): string
    {
        $pageTitle = 'Ajouter une catégorie';

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();

            $category = $post['category'];

            if(!$category)
            {
                FlashBag::addFlash('Le champ est vide', 'error');
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
            'pageTitle' => $pageTitle
        ]);
    }
}