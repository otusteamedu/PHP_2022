<?php

namespace app\services;

use app\models\UserQuery;
use Psr\Http\Message\ResponseInterface;

class ApiResponseService {
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response) {
        $this->response = $response;
    }

    function getCreateQueryResponse(): ResponseInterface {
        try {
            $model = new UserQuery();
            $service = new UserQueryService($model);
            $service->insertToDB();
            $service->publishMessage();
            $id = $service->getModel()->getId();
            $statusCode = 201;
            $data = ['id' => $id];
        } catch (\Exception $e) {
            $data = ['error' => $e->getMessage() ?? 'Adding query error'];
            $statusCode = $e->getCode() ?? 500;
        }
        $data = json_encode($data);
        $this->response->getBody()->write($data);
        return $this->response->withStatus($statusCode);
    }

    function getGetQueryResponse(int $id): ResponseInterface {
        try {
            $model = UserQueryService::getFromDb($id);
            $data = [
                'id' => $model->getId(),
                'status' => $model->getStatus(),
            ];
            $statusCode = 200;
        } catch (\Exception $e) {
            $data = ['error' => $e->getMessage()];
            $statusCode = $e->getCode();
        }
        $data = json_encode($data);
        $this->response->getBody()->write($data);
        return $this->response->withStatus($statusCode);
    }

}
