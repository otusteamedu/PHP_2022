<?php

declare(strict_types=1);

namespace Eliasjump\EmailVerification;

class Render
{

    public function __construct(private string $path = "", private readonly array $response = [])
    {
        if ($path == "") {
            $this->path = __DIR__ . "/../src/template.php";
        }
    }

    public function run(): bool|string
    {
        ob_start();
        $response = $this->response;

        require $this->path;

        return ob_get_clean();
    }
}
