<?php

declare(strict_types=1);

namespace Octopus\App;

use Octopus\App\Storage\RedisStorage;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Octopus\App\Controllers\EventsController;
use DI\ContainerBuilder;
use Octopus\App\Storage\Interfaces\StorageInterface;

class App
{
    public function run(): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            StorageInterface::class =>
            \DI\create(RedisStorage::class)
        ]);

        try {
            $container = $builder->build();
            AppFactory::setContainer($container);
        } catch (\Exception $e) {
        }

        try {
            $app = AppFactory::create();
            $app->addErrorMiddleware(true, true, true);
            $app->any('/', function (ServerRequestInterface $request, ResponseInterface $response) {
                return $response->withStatus(403);
            });
            $app->post('/create', [EventsController::class, 'create']);
            $app->post('/truncate', [EventsController::class, 'truncate']);
            $app->post('/show', [EventsController::class, 'show']);
            $app->run();

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
