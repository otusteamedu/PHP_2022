<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Http;

use App\User\Application\Contract\CreateUserServiceInterface;
use App\User\Application\Dto\CreateUserRequest;
use Core\Http\Contract\HttpRequestInterface;
use Core\Http\Contract\HttpResponseInterface;

class CreateController
{
    private $request;
    private $response;
    private $service;

    public function __construct(HttpRequestInterface $request, HttpResponseInterface $response, CreateUserServiceInterface $service)
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
    }

    public function create(): void
    {
        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'POST') {
                throw new \Exception('Method not allowed');
            }

            $model = new CreateUserRequest();
            $user = $model->fromJson($this->request->getRawPostBody());

            $result = $this->service->createUser($user);

            if ($result->id !== null) {
                $this->response->setData(['id' => $result->id])->asJson();
                $this->response->isOk();
            } else {
                throw new \Exception($result->message);
            }
        } catch (\Exception $ex) {
            $this->response->setData(['message' => $ex->getMessage()])->asJson();
            $this->response->isBad();
        }
    }
}
