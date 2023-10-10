<?php

declare(strict_types=1);

namespace App\Command;

use App\Chat\ChatInterface;
use App\Chat\ServerMode;
use Exception;

class ServerCommand implements CommandInterface
{
    public const ALIAS = 'server';

    public function __construct(readonly private ChatInterface $chat)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $this->chat->start(ServerMode::SERVER);
        $this->chat->stop();
    }
}
