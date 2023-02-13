<?php

namespace App\Controller\Admin\Category;

use App\Framework\AbstractController;

class CategoryController extends AbstractController
{
    public function new(): string
    {
        $pageTitle = 'Ajouter une catégorie';

        return $this->renderAdmin('admin/category/new', [
            'pageTitle' => $pageTitle
        ]);
    }
}