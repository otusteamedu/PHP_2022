<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

class CreateUserRequest
{
    public $email;
    public $phone;
    public $age;

    public function fromJson(string $data): CreateUserRequest
    {
        $user = json_decode($data, true);
        if (empty($user['email'])) {
            throw new \Exception('email is empty');
        }
        if (empty($user['phone'])) {
            throw new \Exception('phone is empty');
        }
        if (empty($user['age'])) {
            throw new \Exception('age is empty');
        }

        $this->email = $user['email'];
        $this->phone = $user['phone'];
        $this->age = $user['age'];

        return $this;
    }
}
