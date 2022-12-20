<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Kernel;

final class Request
{
    use Singleton;

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getPostParameter(string $name)
    {
        if (array_key_exists($name, $_POST)) {
            return $_POST[$name];
        }

        $data = json_decode(file_get_contents('php://input'), true);
        return $data[$name] ?? null;
    }

    public function getGetParameter(string $name)
    {
        return $_GET[$name] ?? null;
    }
}
