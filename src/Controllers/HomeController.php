<?php declare(strict_types=1);

namespace Queen\App\Controllers;

class HomeController extends DefaultController
{
    public function index()
    {
        $this->render('index');
    }
}
