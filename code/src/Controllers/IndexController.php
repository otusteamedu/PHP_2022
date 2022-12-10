<?php

namespace Otus\App\Controllers;

use Otus\App\Viewer\View;

class IndexController
{
    public function index()
    {
        View::render('info',[
            'title' => 'Главная страница',
        ]);
    }

}
