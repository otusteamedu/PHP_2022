<?php

namespace App\Db\Database\IdentityMap\IdentityMap;

use App\Db\Database\IdentityMap\Entity\User;
use WS\Utils\Collections\HashMap;
use WS\Utils\Collections\MapEntry;

class UserIdentityMap
{
    private static HashMap $storage;

    public function __construct()
    {
        self::$storage = new HashMap();
    }

    public static function get(int $id): ?User
    {
        return self::$storage->get($id);
    }

    public static function set(User $user): void
    {
        self::$storage->put($user->getId(), $user);
    }

    public static function remove(int $id): void
    {
        self::$storage->remove($id);
    }

    public static function count(): int
    {
        return self::$storage->size();
    }

    /**
     * @return User[]
     */
    public static function getAll(): array
    {
        return self::$storage
            ->stream()
            ->map(function (MapEntry $mapEntry) {
                return $mapEntry->getValue();
            })
            ->toArray();
    }
}
