<?php

declare(strict_types=1);

namespace App\User\Application\Contract;

use App\User\Application\Dto\CreateUserRequest;
use App\User\Application\Dto\CreateUserResponse;

interface CreateUserServiceInterface
{
    public function createUser(CreateUserRequest $request): CreateUserResponse;
}
