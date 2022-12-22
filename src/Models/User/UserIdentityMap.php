<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Models\User;

use Eliasjump\HwStoragePatterns\Kernel\Singleton;

class UserIdentityMap
{
    use Singleton;

    private array $users = [];

    public function addUser(User $user): void
    {
        $this->users[$user->id] = $user;
    }

    public function getUser(string $id): User
    {
        return $this->users[$id] ?? new User();
    }

    public function unsetUser(string $id): void
    {
        unset($this->users[$id]);
    }
}