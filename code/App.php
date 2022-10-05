<?php

declare(strict_types=1);

namespace App;

use App\Application\Controller\Api\CreditController as ApiCreditController;
use App\Application\Controller\CreditController;
use Bramus\Router\Router;
use DI\Container;
use DI\ContainerBuilder;
use Exception;

class App
{
    private Container $container;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(APP_PATH.'/config.php');
        $this->container = $builder->build();
    }

    public function run(): void
    {
        $router = new Router();

        $router->set404(function () {
            header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
            echo '404, Route not found';
        });

        $router->match('GET|POST', '/', function () {

            $request = $this->container->get('request');
            $dispatcher = $this->container->get('dispatcher');
            $identityMap = $this->container->get('identityMap');
            $amqpConnection = $this->container->get('amqp');
            $memcached = $this->container->get('memcached');

            $controller = new CreditController();
            echo $controller
                ->requestFormPage($request, $dispatcher, $identityMap, $amqpConnection, $memcached)
                ->send();
        });

        $router->set404('/api(/.*)?', function () {
            header('HTTP/1.1 404 Not Found');
            header('Content-Type: application/json');

            echo json_encode(['status' => "404", 'status_text' => "Route not found"], JSON_THROW_ON_ERROR);
        });

        $router->mount('/api', function () use ($router) {
            $router->mount('/requests', function () use ($router) {

                $router->post('/', function () {

                    $request = $this->container->get('request');
                    $dispatcher = $this->container->get('dispatcher');
                    $identityMap = $this->container->get('identityMap');
                    $amqpConnection = $this->container->get('amqp');
                    $memcached = $this->container->get('memcached');

                    $controller = new ApiCreditController();
                    echo $controller
                        ->addCreditRequest($request, $dispatcher, $identityMap, $amqpConnection, $memcached)
                        ->send();
                });

                $router->get('/(\S+)/status', function ($id) {

                    $memcached = $this->container->get('memcached');

                    $controller = new ApiCreditController();
                    echo $controller->getCreditRequestStatus(htmlentities($id), $memcached)->send();
                });

            });
        });

        $router->run();
    }
}