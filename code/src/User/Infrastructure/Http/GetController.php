<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Http;

use App\User\Application\Dto\GetUserRequest;
use App\User\Application\Contract\GetUserServiceInterface;
use Core\Http\Contract\HttpRequestInterface;
use Core\Http\Contract\HttpResponseInterface;

class GetController
{
    private $request;
    private $response;
    private $service;

    public function __construct(HttpRequestInterface $request, HttpResponseInterface $response, GetUserServiceInterface $service)
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
    }

    public function getOne(): void
    {
        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'GET') {
                throw new \Exception('Method not allowed');
            }

            $dto = new GetUserRequest();
            $dto->id = $this->request->getGetParam('id');

            $result = $this->service->getOne($dto);

            if ($result->message !== null) {
                throw new \Exception($result->message);
            }

            $this->response->setData($result->toArray())->asJson()->isOk();
        } catch (\Exception $ex) {
            $this->response->setData(['message' => $ex->getMessage()])->asJson();
            $this->response->isBad();
        }
    }

    public function getAll(): void
    {
        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'GET') {
                throw new \Exception('Method not allowed');
            }

            $result = $this->service->getAll();

            if ($result->message !== null) {
                throw new \Exception($result->message);
            }
            $this->response->setData(['users' => $result->users])->asJson()->isOk();
        } catch (\Exception $ex) {
            $this->response->setData(['message' => $ex->getMessage()])->asJson();
            $this->response->isBad();
        }
    }
}