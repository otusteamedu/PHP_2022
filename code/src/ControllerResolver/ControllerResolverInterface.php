<?php

namespace Nikolai\Php\ControllerResolver;

use Nikolai\Php\Controller\AbstractController;

interface ControllerResolverInterface
{
    public function resolve(): AbstractController;
}