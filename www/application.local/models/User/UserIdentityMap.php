<?php

namespace app\models\User;

class UserIdentityMap {
    private static $instance;
    private array $users = [];

    private function __construct() {}

    public static function getInstance(): self {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    static function addUser(User $user): void {
        $instance = self::getInstance();
        $instance->users[$user->getId()] = $user;
    }

    static function getUser(string $id): ?User {
        $instance = self::getInstance();
        return $instance->users[$id] ?? null;
    }
}
