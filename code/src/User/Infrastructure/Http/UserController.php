<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Infrastructure\Http;

use Kogarkov\Es\User\Application\Contract\CreateUserServiceInterface;
use Kogarkov\Es\User\Application\Dto\CreateUserRequest;
use Kogarkov\Es\User\Application\Contract\UpdateUserServiceInterface;
use Kogarkov\Es\User\Application\Dto\UpdateUserRequest;
use Kogarkov\Es\User\Application\Contract\DeleteUserServiceInterface;
use Kogarkov\Es\User\Application\Dto\DeleteUserRequest;
use Kogarkov\Es\User\Application\Dto\GetUserRequest;
use Kogarkov\Es\User\Application\Contract\GetUserServiceInterface;
use Kogarkov\Es\Core\Http\Contract\HttpResponseInterface;
use Kogarkov\Es\Core\Http\Contract\HttpRequestInterface;
use Kogarkov\Es\Core\Service\Registry;

class UserController
{
    public function __construct(
        private readonly HttpRequestInterface          $request,
        private readonly HttpResponseInterface $response)
    {
    }

    public function getOne(): void
    {
        $response = new HttpResponseInterface();

        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'GET') {
                throw new \Exception('Method not allowed');
            }

            $dto = new GetUserRequest();
            $dto->id = $this->request->getGetParam('id');

            $service = new GetUserServiceInterface();
            $result = $service->getOne($dto);

            if ($result->message !== null) {
                throw new \Exception($result->message);
            }

            $response->setData($result->toArray())->asJson()->isOk();
        } catch (\Exception $ex) {
            $response->setData(['message' => $ex->getMessage()])->asJson();
            $response->isBad();
        }
    }

    public function getAll(): void
    {
        // $response = new HttpResponseInterface();

        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'GET') {
                throw new \Exception('Method not allowed');
            }

            $service = new GetUserServiceInterface();
            $result = $service->getAll();

            if ($result->message !== null) {
                throw new \Exception($result->message);
            }

            $this->response->setData(['users' => $result->users])->asJson()->isOk();
        } catch (\Exception $ex) {
            $this->response->setData(['message' => $ex->getMessage()])->asJson();
            $this->response->isBad();
        }
    }

    public function create(): void
    {
        $response = new HttpResponseInterface();

        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'POST') {
                throw new \Exception('Method not allowed');
            }

            $model = new CreateUserRequest();
            $user = $model->fromJson($this->request->getRawPostBody());

            $service = new CreateUserServiceInterface();
            $result = $service->createUser($user);

            if ($result->id !== null) {
                $response->setData(['id' => $result->id])->asJson();
                $response->isOk();
            } else {
                throw new \Exception($result->message);
            }
        } catch (\Exception $ex) {
            $response->setData(['message' => $ex->getMessage()])->asJson();
            $response->isBad();
        }
    }

    public function update(): void
    {
        $response = new HttpResponseInterface();

        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'PUT') {
                throw new \Exception('Method not allowed');
            }

            $model = new UpdateUserRequest();
            $user = $model->fromJson($this->request->getRawPostBody());

            $service = new UpdateUserServiceInterface();
            $result = $service->updateUser($user);

            if ($result->message !== null) {
                throw new \Exception($result->message);
            }

            $response->isOk();
        } catch (\Exception $ex) {
            $response->setData(['message' => $ex->getMessage()])->asJson();
            $response->isBad();
        }
    }

    public function delete(): void
    {
        $response = new HttpResponseInterface();

        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'PUT') {
                throw new \Exception('Method not allowed');
            }

            $dto = new DeleteUserRequest();
            $dto->id = $this->request->getGetParam('id');

            $service = new DeleteUserServiceInterface();
            $result = $service->deleteUser($dto);

            if ($result->message !== null) {
                throw new \Exception($result->message);
            }

            $response->isOk();
        } catch (\Exception $ex) {
            $response->setData(['message' => $ex->getMessage()])->asJson();
            $response->isBad();
        }
    }
}
