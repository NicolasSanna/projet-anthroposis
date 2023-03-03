<?php 

namespace App\Controller;

use App\Framework\AbstractController;

class HomeController extends AbstractController 
{
    public function index()
    {
        $pageTitle = 'Bienvenue sur Anthroposis';

        return $this->render('home', [
            'pageTitle' => $pageTitle
        ]);
    }

    public function notFound()
    {
        $pageTitle = 'Page introuvable';

        return $this->render('404', [
            'pageTitle' => $pageTitle
        ]);
    }

    public function forbidden()
    {
        $pageTitle = 'Accès refusé';

        return $this->render('403', [
            'pageTitle' => $pageTitle
        ]);
    }
}
