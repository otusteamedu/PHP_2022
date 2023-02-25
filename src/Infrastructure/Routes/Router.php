<?php

declare(strict_types=1);

namespace Src\Infrastructure\Routes;

use Src\Application\Contracts\Infrastructure\Routes\RouterGateway;

final class Router implements RouterGateway
{
    /**
     * @return void
     */
    public function captureRequests(): void
    {
        require_once __DIR__  . "/../../Infrastructure/config/routes/web.php";
    }
}
