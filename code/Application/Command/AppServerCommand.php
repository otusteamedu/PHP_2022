<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Service\Socket\ServerChatInterface;

class AppServerCommand
{
    public function __construct(private readonly ServerChatInterface $server)
    {
    }

    public function run(): void
    {
        $this->server->create();
    }
}