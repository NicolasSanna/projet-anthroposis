<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;

class AdminController extends AbstractController
{
    public function dashboard()
    {
        $pageTitle = 'Administration';

        return $this->renderAdmin('admin/dashboard', [
            'pageTitle' => $pageTitle
        ]);
    }
}