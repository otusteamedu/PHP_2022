<?php

namespace Dmitry\App\Core;

class Request
{

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function __get($name)
    {
        if (!isset($_REQUEST[$name])) {
            return false;
        }

        return ($this->method() === 'POST') ? $_POST[$name] : $_GET[$name];
    }

    public function url(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}