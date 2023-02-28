<?php

namespace App\Http;

class Request
{
    public function post($key)
    {
        return $_POST[$key];
    }

    public function get($key)
    {
        return $_GET[$key];
    }
}
