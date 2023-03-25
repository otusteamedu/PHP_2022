<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Contract;

use Kogarkov\Es\User\Application\Dto\CreateUserRequest;
use Kogarkov\Es\User\Application\Dto\CreateUserResponse;

interface CreateUserServiceInterface
{
    public function createUser(CreateUserRequest $request): CreateUserResponse;
}
