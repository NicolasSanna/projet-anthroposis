<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;

class AdminController extends AbstractController
{
    public function dashboard(): string
    {
        $pageTitle = 'Administration';

        return $this->renderAdmin('admin/dashboard', [
            'pageTitle' => $pageTitle
        ]);
    }

    public function articles(): string
    {
        $pageTitle = 'Administration';

        return $this->renderAdmin('admin/articles', [
            'pageTitle' => $pageTitle
        ]);
    }
}