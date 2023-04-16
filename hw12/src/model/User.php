<?php

declare(strict_types = 1);

namespace Veraadzhieva\Hw12\Model;

class User
{
    private $id;
    private $username;
    private $phone;

    public function __construct($username, $phone) {
        $this->username = $username;
        $this->phone = $phone;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}