<?php

declare(strict_types=1);

use Src\Infrastructure\Routes\Router;
use Src\Application\Contracts\Infrastructure\Routes\RouterGateway;

use function DI\autowire;

return [
    RouterGateway::class => autowire(className: Router::class),
];
