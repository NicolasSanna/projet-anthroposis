<?php

namespace App\Controller\Admin\User;

use App\Framework\Get;
use App\Model\UserModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class UserController extends AbstractController
{
    public function manage(): string
    {
        $pageTitle = 'Membres';
        $token = UserSession::token();

        $userModel = new UserModel();
        $users = $userModel->findAll();

        return $this->renderAdmin('admin/user/users', [
            'pageTitle' => $pageTitle,
            'users' => $users,
            'token' => $token
        ]);
    }

    public function updateToAuthor()
    {
        $userId = (int) Get::key('id');
        $getToken = Get::key('token');
        $token = UserSession::token();

        if($token != $getToken)
        {
            return $this->redirect('403');
        }

        $userModel = new UserModel();
        $userModel->manageToAuthor($userId);

        return $this->redirect('users');
    }

    public function updateToNewUser()
    {
        $userId = (int) Get::key('id');
        $getToken = Get::key('token');
        $token = UserSession::token();

        if($token != $getToken)
        {
            return $this->redirect('403');
        }

        $userModel = new UserModel();
        $userModel->manageToNewUser($userId);

        return $this->redirect('users');
    }
}