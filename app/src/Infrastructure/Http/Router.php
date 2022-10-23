<?php

declare(strict_types=1);

namespace App\Src\Infrastructure\Http;

final class Router
{
    /**
     * @return void
     */
    public function captureRequest(): void
    {
        require_once __DIR__ . '/../../../src/routes/api.php';
    }
}
