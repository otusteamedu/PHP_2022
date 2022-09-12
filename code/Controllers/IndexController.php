<?php

namespace Otus\Mvc\Controllers;

use Otus\Mvc\Core\View;

class IndexController
{
    public function index(): View
    {

        View::render('info',[
            'title' => 'OTUS HW3'
        ]);
    }

}
