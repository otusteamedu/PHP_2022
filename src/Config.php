<?php

namespace App;

class Config
{
    private array $values = [];

    public function __construct()
    {
        $this->values = parse_ini_file(__DIR__ . '/../config/config.ini');
    }


    public function get($key)
    {
        return $this->values[$key];
    }
}
