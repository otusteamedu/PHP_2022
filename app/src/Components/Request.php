<?php

declare(strict_types=1);


namespace ATolmachev\MyApp\Components;


class Request
{
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function post(string $name)
    {
        if ($_POST && isset($_POST[$name])) {
            return $_POST[$name];
        }
        return null;
    }

    public function get(string $name)
    {
        if ($_GET && isset($_GET[$name])) {
            return $_GET[$name];
        }
        return null;
    }
}