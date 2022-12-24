<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases;

use Eliasjump\HwStoragePatterns\Modules\Users\Domain\UserRepository;

class GetUsersList
{
    public static function run(): array
    {
        return (new UserRepository())->all();
    }
}