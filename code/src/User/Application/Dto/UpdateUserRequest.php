<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

class UpdateUserRequest
{
    public $id;
    public $email;
    public $phone;
    public $age;

    public function fromJson(string $data): UpdateUserRequest
    {
        $user = json_decode($data, true);
        if (empty($user['id'])) {
            throw new \Exception('id is empty');
        }
        if (empty($user['email'])) {
            throw new \Exception('email is empty');
        }
        if (empty($user['phone'])) {
            throw new \Exception('phone is empty');
        }
        if (empty($user['age'])) {
            throw new \Exception('age is empty');
        }

        $this->id = $user['id'];
        $this->email = $user['email'];
        $this->phone = $user['phone'];
        $this->age = $user['age'];

        return $this;
    }
}
