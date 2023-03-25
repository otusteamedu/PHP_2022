<?php

declare(strict_types=1);

use Ppro\Hw28\Repository\Repository;
use Ppro\Hw28\Service\Statement\Create;
use Ppro\Hw28\Service\Statement\GetOne;
use Ppro\Hw28\Service\Statement\Processing;
use Psr\Container\ContainerInterface;

return [
//  vars
    'statement_db'=> 'redis',
    'statement_db_credes' => ['host' => 'redis', 'port' => '6379'],

//  factories
  'create_statement_service' => \DI\factory(static fn(
    ContainerInterface $container
  ): Create => new Create($container->get('statement_repository'))),

  'find_statement_service' => \DI\factory(static fn(
    ContainerInterface $container
  ): GetOne => new GetOne($container->get('statement_repository'))),

  'processing_statement_service' => \DI\factory(static fn(
    ContainerInterface $container
  ): Processing => new Processing($container->get('statement_repository'))),

  'statement_repository' => \DI\factory(static fn(
    ContainerInterface $container
  ): Repository => new Repository($container->get('statement_db'),$container->get('statement_db_credes'))),

  // настройки middleware для CLI команд
  'commands' => [
        '__default' => '\Ppro\Hw28\Controller\Cli\DefaultController',
        'statement' => '\Ppro\Hw28\Controller\Cli\StatementController',
    ]
];