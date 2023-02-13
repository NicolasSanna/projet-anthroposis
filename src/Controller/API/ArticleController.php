<?php

namespace App\Controller\API;

use App\Framework\AbstractController;
use App\Framework\Get;
use App\Framework\UserSession;
use App\Model\ArticleModel;

class ArticleController extends AbstractController
{
    public function delete()
    {
        $articleSlug = Get::key('article');
        $getToken = Get::key('token');
        $userId = UserSession::getId();
        $token = UserSession::token();

        if($token != $getToken)
        {
            return $this->redirect('403');
        }

        $articleModel = new ArticleModel();
        $article = $articleModel->delete($userId, $articleSlug);

        if(!empty($article->image))
        {
            unlink(IMAGE_DIR . '/' . $article->image);
        }

        return json_encode($articleSlug);
    }
}