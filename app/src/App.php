<?php

declare(strict_types=1);

namespace Octopus\App;

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Octopus\App\Controllers\EventsController;

class App
{
    public function run(): void
    {

        try {
            $app = AppFactory::create();
            $app->addErrorMiddleware(true, true, true);
            $app->any('/', function (ServerRequestInterface $request, ResponseInterface $response) {
                return $response->withStatus(403);
            });
            $app->post('/create', [EventsController::class, 'create']);
            $app->run();

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
