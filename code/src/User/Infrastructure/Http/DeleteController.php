<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Http;

use App\User\Application\Contract\DeleteUserServiceInterface;
use App\User\Application\Dto\DeleteUserRequest;
use Core\Http\Contract\HttpRequestInterface;
use Core\Http\Contract\HttpResponseInterface;

class DeleteController
{
    private $request;
    private $response;
    private $service;

    public function __construct(HttpRequestInterface $request, HttpResponseInterface $response, DeleteUserServiceInterface $service)
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
    }

    public function delete(): void
    {
        try {
            if ($this->request->getServerParam('REQUEST_METHOD') !== 'DELETE') {
                throw new \Exception('Method not allowed');
            }

            $dto = new DeleteUserRequest();
            $dto->id = $this->request->getGetParam('id');

            $result = $this->service->deleteUser($dto);

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
