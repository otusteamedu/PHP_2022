<?php

declare(strict_types=1);

namespace Src\Application\Contracts\Infrastructure\Routes;

interface RouterGateway
{
    public function captureRequests(): void;
}
