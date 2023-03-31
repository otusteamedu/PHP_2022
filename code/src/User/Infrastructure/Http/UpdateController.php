<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Http;

use App\User\Application\Contract\UpdateUserServiceInterface;
use App\User\Application\Dto\UpdateUserRequest;
use Core\Http\Contract\HttpRequestInterface;
use Core\Http\Contract\HttpResponseInterface;

class UpdateController
{
    private $request;
    private $response;
    private $service;

    public function __construct(HttpRequestInterface $request, HttpResponseInterface $response, UpdateUserServiceInterface $service)
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
    }

    public function update(): void
    {
        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'PUT') {
                throw new \Exception('Method not allowed');
            }

            $model = new UpdateUserRequest();
            $user = $model->fromJson($this->request->getRawPostBody());

            $result = $this->service->updateUser($user);

            if ($result->message !== null) {
                throw new \Exception($result->message);
            }

            $this->response->isOk();
        } catch (\Exception $ex) {
            $this->response->setData(['message' => $ex->getMessage()])->asJson();
            $this->response->isBad();
        }
    }
}
