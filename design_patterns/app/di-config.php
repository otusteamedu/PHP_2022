<?php

use Patterns\App\Application\QueryBuilderInterface;
use Patterns\App\Application\Repository;
use Patterns\App\Infrastructure\Database\QueryBuilder;
use Patterns\App\Infrastructure\Repository\AtmRepository;

return [
    QueryBuilderInterface::class => DI\autowire(QueryBuilder::class),
    Repository::class => DI\autowire(AtmRepository::class),
];
