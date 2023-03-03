<?php

namespace App\Controller\Account;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\Mailing;
use App\Framework\Post;
use App\Framework\UserSession;
use App\Model\UserModel;

class AccountController extends AbstractController
{
    public function signup()
    {
        $pageTitle = 'Inscription';
        $isLogged = UserSession::isAuthenticated();

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

                if($result->message === "Vous êtes bien enregistré, vous pouvez vous connecter")
                {
                    $mailing = new Mailing($post);
                    $mailing->sendToAdmin();
                    $mailing->sendToNewUser();
                }
            }
        }

        return $this->render('account/signup', [
            'pageTitle' => $pageTitle,
            'firstname' => $firstname??'',
            'lastname' => $lastname??'',
            'pseudo' => $pseudo??'',
            'email' => $email??'',
            'isLogged' => $isLogged
        ]);
    }

    public function login()
    {
        $pageTitle = 'Connexion';

        $isLogged = UserSession::isAuthenticated();

        if(Post::checkIsPost())
        {
            $post = Post::checkerForm();

            $email = $post['email'];
            $password = $post['password'];

            if (!$email || !$password)
            {
                FlashBag::addFlash('Tous les champs n\'ont pas été remplis', 'error');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
            }

            $userModel = new UserModel();
            $user = $userModel->checkCredentials($email, $password);

            if(!$user)
            {
                FlashBag::addFlash('Identifiants incorrects', 'error');
            }
            else
            {
                UserSession::register(
                    $user->idUser,
                    $user->firstname,
                    $user->lastname,
                    $user->pseudo,
                    $user->email,
                    $user->user_role_label,
                    $user->role_id
                );

                FlashBag::addFlash('Vous êtes bien connecté');

                return $this->redirect('dashboard');
            }
        }

        return $this->render('account/login', [
            'pageTitle' => $pageTitle, 
            'email' => $email??'',
            'isLogged' => $isLogged
        ]);
    }

    public function logout()
    {
        UserSession::logout();

        return $this->redirect('home');
    }
}