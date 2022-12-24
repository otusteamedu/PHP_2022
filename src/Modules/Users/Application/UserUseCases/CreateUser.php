<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases;

use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserDTO;
use Eliasjump\HwStoragePatterns\Modules\Users\Domain\User;
use Eliasjump\HwStoragePatterns\Modules\Users\Domain\UserRepository;

class CreateUser
{
    public static function run(UserDTO $dto): User
    {
        $user = new User(name: $dto->name, email: $dto->email);
        return (new UserRepository())->create($user);
    }
}