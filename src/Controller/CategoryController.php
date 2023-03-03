<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\CategoryModel;

class CategoryController extends AbstractController
{
    public function getAll()
    {
        $pageTitle = 'Catégories';

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        return $this->render('categories', [
            'pageTitle' => $pageTitle,
            'categories' => $categories
        ]);
    }
}