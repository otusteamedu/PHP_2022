<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\User\Application\Contract\RepositoryInterface;
use App\User\Application\Contract\DeleteUserServiceInterface;
use App\User\Application\Dto\DeleteUserRequest;
use App\User\Application\Dto\DeleteUserResponse;

class DeleteUserService implements DeleteUserServiceInterface
{
    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function deleteUser(DeleteUserRequest $request): DeleteUserResponse
    {
        $response = new DeleteUserResponse();

        try {
            $result = $this->repository->delete((int)$request->id);

            if (!$result) {
                throw new \Exception('Nothing to delete');
            }
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        return $response;
    }
}
