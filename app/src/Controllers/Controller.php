<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Controllers;

use Nemizar\Php2022\Components\Render;

abstract class Controller
{
    protected Render $render;

    public function __construct()
    {
        $this->render = new Render();
    }
}
