<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases;

use Eliasjump\HwStoragePatterns\Modules\Users\Domain\User;
use Eliasjump\HwStoragePatterns\Modules\Users\Domain\UserRepository;

class GetUser
{
    public static function run(string $userId): User
    {
        return (new UserRepository())->getById($userId);
    }
}