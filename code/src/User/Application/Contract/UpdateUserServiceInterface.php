<?php

declare(strict_types=1);

namespace App\User\Application\Contract;

use App\User\Application\Dto\UpdateUserRequest;
use App\User\Application\Dto\UpdateUserResponse;

interface UpdateUserServiceInterface
{
    public function updateUser(UpdateUserRequest $request): UpdateUserResponse;
}
