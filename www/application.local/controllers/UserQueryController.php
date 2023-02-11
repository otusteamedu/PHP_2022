<?php
namespace app\controllers;

use app\models\UserQuery;
use app\services\ApiResponseService;
use app\services\DBService;
use app\services\UserQueryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserQueryController {

    public function create (
        ServerRequestInterface $request,
        ResponseInterface $response, array $args): ResponseInterface
    {
        $responseService = new ApiResponseService($response);
        return $responseService->getCreateQueryResponse();
    }

    public function view (
        ServerRequestInterface $request,
        ResponseInterface $response, array $args): ResponseInterface
    {
        $responseService = new ApiResponseService($response);
        return $responseService->getGetQueryResponse($args['id']);
    }
}
