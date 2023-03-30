<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\User\Domain\Model\UserModel;
use App\User\Application\Contract\RepositoryInterface;
use App\User\Application\Contract\CreateUserServiceInterface;
use App\User\Application\Dto\CreateUserRequest;
use App\User\Application\Dto\CreateUserResponse;

class CreateUserService implements CreateUserServiceInterface
{
    private $repository;

    public function __construct(RepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }

    public function createUser(CreateUserRequest $request): CreateUserResponse
    {
        $response = new CreateUserResponse();

        try {
            $user = new UserModel($request->email, $request->phone, $request->age);

            $result = $this->repository->create($user);

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
