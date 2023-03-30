<?php

declare(strict_types=1);

namespace App\User\Application\Contract;

use App\User\Application\Dto\DeleteUserRequest;
use App\User\Application\Dto\DeleteUserResponse;

interface DeleteUserServiceInterface
{
    public function deleteUser(DeleteUserRequest $request): DeleteUserResponse;
}
