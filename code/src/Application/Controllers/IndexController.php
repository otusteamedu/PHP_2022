<?php

namespace Otus\Mvc\Application\Controllers;

use Otus\Mvc\Application\Viewer\View;

class IndexController
{
    public function index(): View
    {

        View::render('info',[
            'title' => 'Главная страница',
            'name' => 'Anonymous user',
        ]);
    }

}
