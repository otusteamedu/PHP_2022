<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Service;

use Kogarkov\Es\User\Application\Dto\UpdateUserRequest;
use Kogarkov\Es\User\Application\Dto\UpdateUserResponse;
use Kogarkov\Es\User\Application\Contract\UpdateUserServiceInterface;
use Kogarkov\Es\User\Domain\Model\UserModel;
use Kogarkov\Es\User\Domain\Repository\UserRepository;

class UpdateUserService implements UpdateUserServiceInterface
{
    public function updateUser(UpdateUserRequest $request): UpdateUserResponse
    {
        $response = new UpdateUserResponse();

        try {
            $user = new UserModel($request->email, $request->phone, $request->age, $request->id);

            $repository = new UserRepository();
            $result = $repository->update($user);

            if (!$result) {
                throw new \Exception('Nothing to update');
            }
        } catch (\Exception $e) {
            $response->message = $e->getMessage();
        }

        return $response;
    }
}
