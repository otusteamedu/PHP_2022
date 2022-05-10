<?php

use App\Ddd\Application\RepositoryFactory;
use App\Ddd\Infrastructure\Repository\Factory\EventRepositoryFactory;

return [
    RepositoryFactory::class => DI\autowire(EventRepositoryFactory::class),
];
