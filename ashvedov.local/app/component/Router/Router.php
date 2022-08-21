<?php

declare(strict_types=1);

namespace App\Component\Router;

final class Router
{
    /**
     * @return void
     */
    public function captureRequest(): void
    {
        require_once __DIR__ . '/../../../app/config/routes.php';
    }
}
