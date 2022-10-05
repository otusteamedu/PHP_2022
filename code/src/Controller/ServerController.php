<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Nikolai\Php\Service\ServerService;

class ServerController extends AbstractController
{
    public function __invoke(...$values)
    {
        (new ServerService($values[0]))->run();
    }
}