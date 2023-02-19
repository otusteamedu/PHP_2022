<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Otus\Task13\Core\Config\Config;
use Otus\Task13\Core\Config\Contracts\ConfigInterface;
use Otus\Task13\Core\Http\Contract\HttpRequestInterface;
use Otus\Task13\Core\Http\HttpRequest;
use Otus\Task13\Core\ORM\Contract\DatabaseInterface;
use Otus\Task13\Core\ORM\Contract\EntityManagerContract;
use Otus\Task13\Core\ORM\Database;
use Otus\Task13\Core\ORM\EntityManager;

return static function (ContainerConfigurator $containerConfigurator) {

    $services = $containerConfigurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set(EntityManagerContract::class, EntityManager::class);
    $services->set(DatabaseInterface::class, Database::class)->args([[
        'driver' => 'sqlite',
        'name' => __DIR__ . "/../sqlite.db"
    ]]);

    $services->set(HttpRequestInterface::class, HttpRequest::class)->args([$_POST]);
    $services->set(ConfigInterface::class, Config::class)->args([__DIR__ . '/app.php']);

    $services->load('Otus\\Task13\\', '../src/')
        // Otus\Task13\Product\Domain\ValueObject
        ->exclude('../src/Product/Domain/ValueObject')
        ->exclude('../src/Product/Application/{Dto}');

};