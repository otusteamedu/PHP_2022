<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\User\Application\Contract\RepositoryInterface;
use App\User\Application\Contract\UpdateUserServiceInterface;
use App\User\Application\Dto\UpdateUserRequest;
use App\User\Application\Dto\UpdateUserResponse;
use App\User\Domain\Model\UserModel;

class UpdateUserService implements UpdateUserServiceInterface
{
    private $repository;

    public function __construct(RepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }

    public function updateUser(UpdateUserRequest $request): UpdateUserResponse
    {
        $response = new UpdateUserResponse();

        try {
            $user = new UserModel($request->email, $request->phone, $request->age, $request->id);

            $result = $this->repository->update($user);

            if (!$result) {
                throw new \Exception('Nothing to update');
            }
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        return $response;
    }
}
