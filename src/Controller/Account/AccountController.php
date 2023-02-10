<?php

namespace App\Controller\Account;

use App\Framework\AbstractController;

class AccountController extends AbstractController
{
    public function signup()
    {
        $pageTitle = 'Inscription';

        return $this->render('signup/signup', [
            'pageTitle' => $pageTitle
        ]);
    }
}