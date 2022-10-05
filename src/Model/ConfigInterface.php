<?php

namespace App\Model;

interface ConfigInterface
{
    public function get(string $key);
}