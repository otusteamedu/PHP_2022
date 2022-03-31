<?php

namespace App\Http;

class Request
{
    private array $post = [];
    private array $get = [];

    public function __construct()
    {
        foreach ($_POST as $field => $value) {
            $this->set('post', $field, $value);
        }

        foreach ($_GET as $field => $value) {
            $this->set('get', $field, $value);
        }
    }

    public function set($type, $key, $value): void
    {
        $this->{$type}[$key] = $value;
    }

    public function post($key)
    {
        return $this->post[$key];
    }

    public function get($key)
    {
        return $this->get[$key];
    }
}
