<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Service;

use Kogarkov\Es\User\Application\Contract\DeleteUserServiceInterface;
use Kogarkov\Es\User\Application\Dto\DeleteUserRequest;
use Kogarkov\Es\User\Application\Dto\DeleteUserResponse;
use Kogarkov\Es\User\Domain\Model\UserModel;
use Kogarkov\Es\User\Domain\Repository\UserRepository;

class DeleteUserService implements DeleteUserServiceInterface
{
    public function deleteUser(DeleteUserRequest $request): DeleteUserResponse
    {
        $response = new DeleteUserResponse();

        try {
            $repository = new UserRepository();
            $result = $repository->delete($request->id);

            if (!$result) {
                throw new \Exception('Nothing to delete');
            }
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }
        
        return $response;
    }
}
