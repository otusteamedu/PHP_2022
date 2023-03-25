<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Contract;

use Kogarkov\Es\User\Application\Dto\UpdateUserRequest;
use Kogarkov\Es\User\Application\Dto\UpdateUserResponse;

interface UpdateUserServiceInterface
{
    public function updateUser(UpdateUserRequest $request): UpdateUserResponse;
}
