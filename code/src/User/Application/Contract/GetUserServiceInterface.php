<?php

declare(strict_types=1);

namespace App\User\Application\Contract;

use App\User\Application\Dto\GetUserRequest;
use App\User\Application\Dto\GetOneUserResponse;
use App\User\Application\Dto\GetAllUserResponse;

interface GetUserServiceInterface
{
    public function getOne(GetUserRequest $request): GetOneUserResponse;
    public function getAll(): GetAllUserResponse;
}
