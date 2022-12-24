<?php

namespace Study\Cinema;


use Study\Cinema\Controller\EventController;
use Study\Cinema\DTO\EventCreateDTO;
use Study\Cinema\Redis\RedisClient;
use Study\Cinema\Helper\DotEnv;
use Study\Cinema\Repository\EventRepository;
use Study\Cinema\Response\Response;

class App
{
    private Response $response;
    const ALLOWED_ACTIONS = ['create', 'get', 'delete'];
    public function __construct()
    {
    }
    public function run()
    {
        (new DotEnv(__DIR__ . '/../.env'))->load();
        $redis = new RedisClient();
        $eventRepository = new EventRepository($redis);
        $controller = new EventController($eventRepository);
        $this->response = new Response();

        $url = strtok($_SERVER["REQUEST_URI"], '?');
        $action_name = '';
        $routes = explode('/', $url);
        if (empty($routes[2] && in_array(strtolower($routes[2]),self::ALLOWED_ACTIONS)) ) {
                return $this->response->sendResponse( Response::HTTP_CODE_BAD_REQUEST, "Действие не определено" );
        }
        $action_name = strtolower($routes[2]);
        if(!method_exists($controller, $action_name)) {
            return $this->response->sendResponse( Response::HTTP_CODE_BAD_REQUEST, "Действие не реализовано.");
        }


        if($url == '/event/create' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            if(empty($_POST)) {
               return $this->response->sendResponse(Response::HTTP_CODE_BAD_REQUEST, "Нет параметров для создания события" );
            }
            $dto = new EventCreateDTO();
            $dto->priority  = $_POST['priority'] ?? 0;
            $dto->conditions  = $_POST['conditions'] ?? [];

                if($controller->$action_name($dto)) {
                    return $this->response->sendResponse( Response::HTTP_CODE_OK, "Событие создано" );
                }
                else {
                    return $this->response->sendResponse(Response::HTTP_CODE_BAD_REQUEST, "Не удалось создать событие." );
                }
        }
        else if($url == '/event/delete' && $_SERVER['REQUEST_METHOD'] == 'DELETE')
        {
            if($controller->$action_name()) {
                return $this->response->sendResponse( Response::HTTP_CODE_OK, "События удалены." );
            }
            else {
                return $this->response->sendResponse(Response::HTTP_CODE_BAD_REQUEST, "Не удалось создать событие." );
            }
        }
        else if($url == '/event/get' && $_SERVER['REQUEST_METHOD'] == 'GET') {
            $conditions = $_GET;
            $event = $controller->$action_name($conditions);
            if($event) {
                return $this->response->sendResponse(Response::HTTP_CODE_OK, $event);
            }
            else {
                return $this->response->sendResponse(Response::HTTP_CODE_BAD_REQUEST, "Событие не найдено." );
            }

        }

    }

}
