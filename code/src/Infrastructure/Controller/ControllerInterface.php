<?php

namespace Cookapp\Php\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Controller interface
 */
interface ControllerInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request);
}
