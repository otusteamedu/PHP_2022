<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Contract;

use Kogarkov\Es\User\Application\Dto\GetUserRequest;
use Kogarkov\Es\User\Application\Dto\GetOneUserResponse;
use Kogarkov\Es\User\Application\Dto\GetAllUserResponse;

interface GetUserServiceInterface
{
    public function getOne(GetUserRequest $request): GetOneUserResponse;
    public function getAll(): GetAllUserResponse;
}
