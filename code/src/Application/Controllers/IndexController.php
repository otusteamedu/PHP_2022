<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Application\Viewer\View;

class IndexController
{
    public function index()
    {
        View::render('info',[
            'title' => 'Главная страница',
        ]);
    }
}
