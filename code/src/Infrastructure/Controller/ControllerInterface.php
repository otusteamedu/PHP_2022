<?php

namespace Nikolai\Php\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Request;

interface ControllerInterface
{
    public function __invoke(Request $request);
}