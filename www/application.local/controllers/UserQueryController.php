<?php
namespace app\controllers;

use app\models\UserQuery;
use app\services\DBService;
use app\services\UserQueryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserQueryController {

    public function create (
        ServerRequestInterface $request,
        ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $id = UserQueryService::addNewQuery();
            $statusCode = 201;
            $data = ['id' => $id];
        } catch (\Exception $e) {
            $data = ['error' => 'Adding query error'];
            $statusCode = 500;
        }

        $data = json_encode($data);
        $response->getBody()->write($data);
        return $response->withStatus($statusCode);
    }

    public function view (
        ServerRequestInterface $request,
        ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            if (!ctype_digit($args['id'])) {
                throw new \Exception('id must be int', 400);
            }
            $status = UserQueryService::getQueryStatus($args['id']);
            $data = [
                'id' => $args['id'],
                'status' => $status,
            ];
            $statusCode = 200;
        } catch (\Exception $e) {
            $data = ['error' => $e->getMessage()];
            $statusCode = $e->getCode();
        }

        $data = json_encode($data);
        $response->getBody()->write($data);
        return $response->withStatus($statusCode);
    }
}
