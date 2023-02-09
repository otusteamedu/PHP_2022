<?php
namespace app\controllers;

use app\models\Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserQueryController {

    public function create (
        ServerRequestInterface $request,
        ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write("Запрос создан");
        return $response;
    }

    public function view (
        ServerRequestInterface $request,
        ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write("Статус запроса {$args['id']} такой-то");
        return $response;
    }
}
