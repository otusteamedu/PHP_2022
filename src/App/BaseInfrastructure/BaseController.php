<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\App\BaseInfrastructure;

use Eliasjump\HwStoragePatterns\App\Kernel\Request;

abstract class BaseController
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }
}
