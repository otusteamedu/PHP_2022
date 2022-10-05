<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Nikolai\Php\Service\ClientService;

class ClientController extends AbstractController
{
    public function __invoke(...$values)
    {
        (new ClientService($values[0]))->run();
    }
}