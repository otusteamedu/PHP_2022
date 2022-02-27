<?php

declare(strict_types=1);

namespace Philip\Otus\FrontController;

use Philip\Otus\FrontController\View\HomeView;

class Dispatcher
{
    public function dispatch()
    {
        (new HomeView)->show();
    }
}