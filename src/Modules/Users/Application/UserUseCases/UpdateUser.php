<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases;

use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserDTO;
use Eliasjump\HwStoragePatterns\Modules\Users\Domain\User;
use Eliasjump\HwStoragePatterns\Modules\Users\Domain\UserRepository;

class UpdateUser
{
    public static function run(UserDTO $dto): User
    {
        $user = new User(id: $dto->id);
        if ($dto->name !== '') {
            $dto->name = $user->name;
        }
        if ($dto->email !== '') {
            $dto->email = $user->email;
        }

        return (new UserRepository())->update($user);
    }
}