<?php

declare(strict_types=1);

namespace Svatel\Code\Gateway;

use Svatel\Code\Infrastructure\Controller;
use Svatel\Code\Infrastructure\Request;
use Svatel\Code\Infrastructure\RequestStatus;

final class ApiGateway
{
    private RequestStatus $requestStatus;

    public function __construct(RequestStatus $requestStatus) {
        $this->requestStatus = $requestStatus;
    }

    /**
     * @throws \HttpException
     */
    public function run()
    {
        $res = $this->requestStatus->isPost($_SERVER);

        if (!$res) {
            throw new \HttpException('Должен быть тип POST');
        }

        $post = json_decode(file_get_contents("php://input"), true);
        $request = Request::create($post);
        $controller = new Controller($request);
        $res = $controller->checkEmail();

        print_r($res->getMessage());
    }
}
