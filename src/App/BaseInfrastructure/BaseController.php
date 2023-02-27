<?php

declare(strict_types=1);

namespace Eliasj\Hw16\App\BaseInfrastructure;

use Eliasj\Hw16\App\Kernel\Request;

abstract class BaseController
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }
}
