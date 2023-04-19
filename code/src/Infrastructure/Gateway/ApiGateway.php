<?php

declare(strict_types=1);

namespace Svatel\Code\Infrastructure\Gateway;

use Svatel\Code\Infrastructure\Http\Controller;
use Svatel\Code\Infrastructure\Http\Request;
use Svatel\Code\Infrastructure\Http\RequestStatus;

final class ApiGateway
{
    private RequestStatus $requestStatus;

    public function __construct(RequestStatus $requestStatus)
    {
        $this->requestStatus = $requestStatus;
    }

    /**
     * @throws \HttpException
     * @throws \Exception
     */
    public function run(): void
    {
        $res = $this->requestStatus->isPost($_SERVER);

        if (!$res) {
            throw new \HttpException('Должен быть тип POST');
        }

        $post = json_decode(file_get_contents("php://input"), true);
        $request = Request::create($post);
        $uri = $_SERVER['REQUEST_URI'];
        $controller = new Controller($request);
        if (strpos($uri, 'addEvent')) {
            $res = $controller->addEvent();
        } elseif (strpos($uri, 'addSubscribe')) {
            $res =$controller->addSubscribe();
        } else {
            throw new \Exception('Не валидный метод');
        }

        print_r($res->getMessage());
    }
}