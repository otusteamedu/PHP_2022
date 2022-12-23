<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Controllers;

use Eliasjump\HwStoragePatterns\Kernel\Request;

abstract class BaseController
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }
}
