<?php

namespace Nikolai\Php\Kernel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface KernelInterface
{
    public function process(Request $request): ?Response;
}