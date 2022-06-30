<?php

namespace App\Service;

use App\Models\User;

class UserService
{
    public function addUser(array $data): int
    {
        $user = new User();
        $user->name = (string)$data['name'];
        $user->surname = (string)$data['surname'];
        $user->email = (string)$data['email'];

        $user->save();

        return (int)$user->id;
    }

    public function getUser(int $id): User
    {
        return User::find($id);
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return User::all()->toArray();
    }
}
