<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Service\Socket\ClientChatInterface;

class AppClientCommand
{
    public function __construct(private readonly ClientChatInterface $client)
    {
    }

    public function run(): void
    {
        $this->client->create();
    }
}