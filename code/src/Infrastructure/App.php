<?php

namespace Study\Cinema\Infrastructure;


use Study\Cinema\Infrastructure\Exception\RoutingException;
use Study\Cinema\Infrastructure\HTTP\Controller\EventController;
use Study\Cinema\Infrastructure\HTTP\Controller\RequestValidator;
use Study\Cinema\Infrastructure\Redis\RedisClient;
use Study\Cinema\Infrastructure\Repository\EventRepository;
use Study\Cinema\Infrastructure\Response\Response;

use Study\Cinema\Application\DTO\EventCreateDTO;
use Study\Cinema\Application\Helper\DotEnv;

class App
{
    private Response $response;
    const ALLOWED_ACTIONS = ['create', 'get', 'delete'];
    public function __construct()
    {
    }
    public function run()
    {
        (new DotEnv(__DIR__ . '/../../.env'))->load();
        $redis = new RedisClient();
        $eventRepository = new EventRepository($redis);
        $this->response = new Response();
        $validator = new RequestValidator();
        $controller = new EventController($eventRepository, $this->response,$validator);


        $url = strtok($_SERVER["REQUEST_URI"], '?');
        $routes = explode('/', $url);
        if (empty($routes[2] && in_array(strtolower($routes[2]),self::ALLOWED_ACTIONS)) ) {
                throw new RoutingException("Действие не определено");
        }
        $action_name = strtolower($routes[2]);
        if(!method_exists($controller, $action_name)) {
            throw new RoutingException("Действие не реализовано.");
        }
        $controller->$action_name($_REQUEST);


    }

}
