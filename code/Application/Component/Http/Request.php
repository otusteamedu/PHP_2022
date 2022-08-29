<?php

declare(strict_types=1);

namespace App\Application\Component\Http;

class Request
{
    /** Request body parameters ($_POST) */
    public array $request;

    /** Query string parameters ($_GET) */
    public array $query;

    public function __construct(array $query = [], array $request = [])
    {
        $this->request = $request;
        $this->query = $query;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->query)) {
            return $this->query[$key];
        }

        if (array_key_exists($key, $this->request)) {
            return $this->request[$key];
        }

        return $default;
    }
}