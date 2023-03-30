<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\User\Application\Contract\RepositoryInterface;
use App\User\Application\Contract\GetUserServiceInterface;
use App\User\Application\Dto\GetUserRequest;
use App\User\Application\Dto\GetOneUserResponse;
use App\User\Application\Dto\GetAllUserResponse;

class GetUserService implements GetUserServiceInterface
{
    private $repository;

    public function __construct(RepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }

    public function getOne(GetUserRequest $request): GetOneUserResponse
    {
        $response = new GetOneUserResponse();

        try {
            $result = $this->repository->findOne((int)$request->id);

            if (!$result) {
                throw new \Exception('User not found');
            }

            $response->id = $result->getId();
            $response->email = $result->getEmail()->getValue();
            $response->phone = $result->getPhone()->getValue();
            $response->age = $result->getAge()->getValue();
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        return $response;
    }

    public function getAll(): GetAllUserResponse
    {
        $response = new GetAllUserResponse();

        try {
            $results = $this->repository->getAll();

            foreach ($results as $result) {
                $response->users[] = [
                    'id' => $result->getId(),
                    'email' => $result->getEmail()->getValue(),
                    'phone' => $result->getPhone()->getValue(),
                    'age' => $result->getAge()->getValue(),
                ];
            }
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        
        return $response;
    }
}
