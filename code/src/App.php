<?php

declare(strict_types=1);

namespace Svatel\Code;

use Svatel\Code\Client\RedisClient;
use Svatel\Code\Http\Request\RequestStatus;

final class App
{
    private RequestStatus $requestStatus;
    public function __construct()
    {
        $this->requestStatus = new RequestStatus();
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        if ($this->requestStatus->checkMethod($_SERVER)) {
            $client = new RedisClient();
            $controller = new Controller\Controller($client);
            $uri = $_SERVER['REQUEST_URI'];
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $post = json_decode(file_get_contents("php://input"), true);
                    $request = new Http\Request\Request($post);
                    if (strpos($uri, 'getByBody')) {
                        $request = new Http\Request\Request($post);
                        $res = $controller->getByBody($request);
                        if ($res->getStatusCode() == 201) {
                            print_r($res->getBody());
                        } else {
                            print_r($res->getMessage());
                        }
                    } elseif (strpos($uri, 'add')) {
                        $res = $controller->add($request);
                        print_r($res->getMessage());
                    } else {
                        print_r('Неверный роут');
                    }
                    break;
                case 'GET':
                    if (strpos($uri, 'all')) {
                        $res = $controller->all();
                        if ($res->getStatusCode() == 201) {
                            print_r($res->getBody());
                        } else {
                            print_r($res->getMessage());
                        }
                    } else {
                        print_r('Неверный роут');
                    }
                    break;
                case 'DELETE':
                    if (strpos($uri, 'delete')) {
                        $res = $controller->delete();
                        print_r($res->getMessage());
                        break;
                    } else {
                        print_r('Неверный роут');
                    }
            }
        } else {
            throw new \Exception('Выберите тип метода');
        }
    }
}
