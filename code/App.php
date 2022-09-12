<?php

declare(strict_types=1);

namespace App;

use App\Application\Controller\CreditController;
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

    public function run(): string
    {
        $request = $this->container->get('request');
        $dispatcher = $this->container->get('dispatcher');
        $identityMap = $this->container->get('identityMap');
        $amqpConnection = $this->container->get('amqp');

        $controller = new CreditController();

        return $controller->requestFormPage($request, $dispatcher, $identityMap, $amqpConnection)->send();
    }
}