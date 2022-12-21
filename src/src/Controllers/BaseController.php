<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Controllers;

use Eliasjump\HwRedis\Kernel\Request;

abstract class BaseController
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }
}
