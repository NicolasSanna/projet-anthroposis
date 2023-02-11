<?php

namespace App\Controller\Account;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\Post;
use App\Model\UserModel;

class AccountController extends AbstractController
{
    public function signup(): string
    {
        $pageTitle = 'Inscription';

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();

            $firstname = $post['firstname'];
            $lastname = $post['lastname'];
            $email = $post['email'];
            $pseudo = $post['pseudo'];
            $password = $post['password'];
            $confirmPassword = $post['confirmPassword'];

            if(!$firstname || !$lastname || !$email || !$pseudo || !$password || !$confirmPassword)
            {
                FlashBag::addFlash('Tous les champs n\'ont pas été remplis', 'error');
            }

            if (strlen($password) < 8)
            {
                FlashBag::addFlash("Le mot de passe doit contenir au moins 8 caractères.", 'error');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
            }

            if($password != $confirmPassword)
            {
                FlashBag::addFlash("Le mot de passe confirmé ne correspond pas à celui que vous voulez utiliser.", 'error');
            }

            $uppercase      = preg_match('@[A-Z]@', $password);
            $lowercase      = preg_match('@[a-z]@', $password);
            $number         = preg_match('@[0-9]@', $password);
            $specialChars   = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialChars) 
            {
                FlashBag::addFlash("Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial", 'error');
            }

            if(!FlashBag::hasMessages('error'))
            {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                $userModel = new UserModel();
                $result = $userModel->insert($firstname, $lastname, $pseudo, $email, $hashPassword);

                FlashBag::addFlash($result->message, 'query');
            }
        }

        return $this->render('signup/signup', [
            'pageTitle' => $pageTitle,
            'firstname' => $firstname??'',
            'lastname' => $lastname??'',
            'pseudo' => $pseudo??'',
            'email' => $email??'',
        ]);
    }
}