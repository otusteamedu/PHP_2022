<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

class GetOneUserResponse
{
    public $id;
    public $email;
    public $phone;
    public $age;
    
    public $message;

    public function toArray() {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'age' => $this->age,
        ];
    }
}
