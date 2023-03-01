<?php

namespace App\Controller\Admin\User;

use App\Framework\Get;
use App\Model\UserModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\Mailing;
use App\Framework\Post;

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

    public function updateToAuthor(): mixed
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

        $user = $userModel->getOneById($userId);

        $mailing = new Mailing($user);
        $mailing->sendToNewAuthor();

        return $this->redirect('users');
    }

    public function updateToNewUser(): mixed
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

    public function personalInformations(): string
    {
        $pageTitle = 'Informations personnelles';

        $lastname = UserSession::getLastname();
        $firstname = UserSession::getFirstname();
        $email = UserSession::getEmail();
        $pseudo = UserSession::getPseudo();
        $userId = UserSession::getId();

        $token = UserSession::token();

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();

            $newLastname = $post['lastname'];
            $newFirstname = $post['firstname'];
            $newEmail = $post['email'];
            $newPseudo = $post['pseudo'];
            $checkToken = $post['checkToken'];

            if(!$newLastname || !$newFirstname || !$newEmail || !$newPseudo)
            {
                FlashBag::addFlash('Tous les champs ne sont pas remplis', 'error');
            }

            if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL))
            {
                FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
            }

            if($checkToken != $token)
            {
                FlashBag::addFlash('Le token de session ne correspond pas à celui du formulaire', 'error');
            }

            if(!FlashBag::hasMessages('error'))
            {
                $userModel = new UserModel();
                $userUpdate = $userModel->updatePersonalInfos($userId, $newLastname, $newFirstname, $newPseudo, $newEmail);

                FlashBag::addFlash($userUpdate->message, 'query');
            }
        }

        return $this->renderAdmin('admin/user/personal-informations', [
            'pageTitle' => $pageTitle,
            'lastname' => $newLastname??$lastname,
            'firstname' => $newFirstname??$firstname,
            'email' => $newEmail??$email,
            'pseudo' => $newPseudo??$pseudo,
            'token' => $token
        ]);
    }
}