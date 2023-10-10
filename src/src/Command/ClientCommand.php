<?php

declare(strict_types=1);

namespace App\Command;

use App\Chat\ChatInterface;
use App\Chat\ServerMode;
use Exception;

class ClientCommand implements CommandInterface
{
    public const ALIAS = 'client';

    public function __construct(readonly private ChatInterface $chat)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $this->chat->start(ServerMode::CLIENT);
        $this->chat->stop();
    }
}
