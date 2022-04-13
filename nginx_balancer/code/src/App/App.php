<?php

declare(strict_types=1);
namespace Mapaxa\BalancerApp\App;


use Mapaxa\BalancerApp\Exception\RoutesFileException;
use Mapaxa\BalancerApp\Router;
use Mapaxa\BalancerApp\Service\Http\Response;

class App
{
    private Router $router;

    public function __construct()
    {
        try {
            $this->router = new Router();
        } catch (RoutesFileException $e) {
            echo $e->getMessage();
            die;
            // Response::setResponseCode(404);
        }
    }

    public function run(): void
    {
        if ($this->router instanceof Router) {
            $this->router->run();
        }
    }
}