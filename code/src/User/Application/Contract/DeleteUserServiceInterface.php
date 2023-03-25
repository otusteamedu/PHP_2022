<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Contract;

use Kogarkov\Es\User\Application\Dto\DeleteUserRequest;
use Kogarkov\Es\User\Application\Dto\DeleteUserResponse;

interface DeleteUserServiceInterface
{
    public function deleteUser(DeleteUserRequest $request): DeleteUserResponse;
}
