<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases;

use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserDTO;
use Eliasjump\HwStoragePatterns\Modules\Users\Domain\User;
use Eliasjump\HwStoragePatterns\Modules\Users\Domain\UserRepository;

class DeleteUser
{
    public static function run(string $userId): void
    {
        (new UserRepository())->delete($userId);
    }
}