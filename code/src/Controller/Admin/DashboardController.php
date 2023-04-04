<?php

namespace App\Controller\Admin;

use App\Entity\Course;

class DashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.twig');
    }

    public function configureMenuItems(): iterable
    {

    }
}
