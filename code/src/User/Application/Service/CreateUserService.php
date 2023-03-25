<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Service;

use Kogarkov\Es\User\Application\Contract\CreateUserServiceInterface;
use Kogarkov\Es\User\Application\Dto\CreateUserRequest;
use Kogarkov\Es\User\Application\Dto\CreateUserResponse;
use Kogarkov\Es\User\Domain\Model\UserModel;
use Kogarkov\Es\User\Domain\Repository\UserRepository;

class CreateUserService implements CreateUserServiceInterface
{
    public function createUser(CreateUserRequest $request): CreateUserResponse
    {
        $response = new CreateUserResponse();

        try {
            $user = new UserModel($request->email, $request->phone, $request->age);

            $repository = new UserRepository();
            $result = $repository->create($user);

            if ($result) {
                $response->id = $result;
            } else {
                throw new \Exception('User not added');
            }
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        
        return $response;
    }
}
