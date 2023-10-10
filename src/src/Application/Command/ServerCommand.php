<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Chat\ServerInterface;
use Exception;

class ServerCommand implements CommandInterface
{
    public const ALIAS = 'server';

    public function __construct(readonly private ServerInterface $chat)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $this->chat->start();
        $this->chat->stop();
    }
}
