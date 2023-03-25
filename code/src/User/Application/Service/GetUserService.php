<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Service;

use Kogarkov\Es\User\Application\Contract\GetUserServiceInterface;
use Kogarkov\Es\User\Application\Dto\GetUserRequest;
use Kogarkov\Es\User\Application\Dto\GetOneUserResponse;
use Kogarkov\Es\User\Application\Dto\GetAllUserResponse;
use Kogarkov\Es\User\Domain\Repository\UserRepository;

class GetUserService implements GetUserServiceInterface
{
    public function getOne(GetUserRequest $request): GetOneUserResponse
    {
        $response = new GetOneUserResponse();

        try {
            $repository = new UserRepository();
            $result = $repository->findOne($request->id);

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
            $repository = new UserRepository();
            $results = $repository->getAll();

            foreach ($results as $result) {
                $response['users'][] = [
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
