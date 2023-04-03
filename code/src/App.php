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

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $post = json_decode(file_get_contents("php://input"), true);
                    $request = new Http\Request\Request($post);
                    $controller->add($request);
                    break;
                case 'GET':
                    if (strpos($_SERVER['REQUEST_URI'], 'param1')) {
                        preg_match_all('/param\d=\d/', $_SERVER['REQUEST_URI'], $query);
                        $request = new Http\Request\Request($query);
                        $controller->getByPriority($request);
                    } else {
                        $controller->all();
                    }
                    break;
                case 'DELETE':
                    $controller->delete();
                    break;
            }

        } else {
            throw new \Exception('Выберите тип метода');
        }
    }
}
