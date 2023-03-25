<?php

namespace Ppro\Hw28\Application;

use Ppro\Hw28\Controller\Statement\GetOne;
use Ppro\Hw28\Controller\Statement\Create;
use Ppro\Hw28\Controller\Main;
use Slim\App as SlimApp;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;
use Middlewares\TrailingSlash;

class Routes
{
    /**
     * @param SlimApp $app
     * @return SlimApp
     */
    public static function setRoutes(SlimApp $app): SlimApp
    {
        //add trailing slash
        $app->add(new TrailingSlash(true));

        // enable lazy CORS
        $app->options('/{routes:.+}', function ($request, $response) {
            return $response;
        });

        $app->add(function ($request, $handler) {
            $response = $handler->handle($request);
            return $response
              ->withHeader('Access-Control-Allow-Origin', '*')
              ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
              ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });

        //set routes
        $app->get('/', Main::class);

        $app->group('/api/v1', function (RouteCollectorProxy $group): void {
            $group->group('/statement', function (RouteCollectorProxy $subGroup): void {
                $subGroup->post('/', Create::class);
                $subGroup->get('/{id}/', GetOne::class);
            });
        });

        //set 404
        $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
            throw new HttpNotFoundException($request);
        });

        return $app;
    }
}