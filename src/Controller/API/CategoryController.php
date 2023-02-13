<?php

namespace App\Controller\API;

use App\Framework\Get;
use App\Model\CategoryModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class CategoryController extends AbstractController
{
    public function deleteWithArticles(): string
    {
        $categoryId = Get::key('id');
        $getToken = Get::key('token');
        $token = UserSession::token();

        if($token != $getToken)
        {
            return $this->redirect('403');
        }

        $categoryModel = new CategoryModel();
        $categoryModel->deleteWithArticles($categoryId);

        return json_encode($categoryId);
    }

    public function deleteWithoutArticles(): string
    {
        $categoryId = Get::key('id');
        $getToken = Get::key('token');
        $token = UserSession::token();

        if($token != $getToken)
        {
            return $this->redirect('403');
        }

        $categoryModel = new CategoryModel();
        $categoryModel->deleteWithoutArticles($categoryId);

        return json_encode($categoryId);
    }
}