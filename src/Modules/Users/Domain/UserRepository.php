<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Domain;

class UserRepository
{
    private UserMapper $userMapper;
    private UserIdentityMap $userIdentityMap;

    public function __construct()
    {
        $this->userMapper = new UserMapper();
        $this->userIdentityMap = UserIdentityMap::getInstance();
    }

    public function all(): array
    {
        $users = $this->userMapper->all();

        foreach ($users as $user) {
            $this->userIdentityMap->addUser($user);
        }
        return $users;
    }

    public function create(User $user): User
    {

        $user = $this->userMapper->save($user);

        $this->userIdentityMap->addUser($user);

        return $user;
    }

    public function getById(string $userId): User
    {
        $user = $this->userIdentityMap->getUser($userId);
        if (!$user->id) {
            $user = $this->userMapper->findById($userId);
        }
        return $user;
    }

    public function update(User $user): User
    {
        $user = $this->userMapper->update($user);
        $this->userIdentityMap->addUser($user);

        return $user;
    }

    public function delete(string $userId): void
    {
        $this->userMapper->destroy($userId);
        $this->userIdentityMap->unsetUser($userId);
    }
}