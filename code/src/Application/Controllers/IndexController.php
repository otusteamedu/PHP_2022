<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Application\Viewer\View;

/**
 * App index
 */
class IndexController
{
    /**
     * Main page
     * @return void
     */
    public function index()
    {
        View::render('info', [
            'title' => 'Главная страница',
        ]);
    }
}
