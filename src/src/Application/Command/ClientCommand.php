<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Chat\ClientInterface;
use Exception;

class ClientCommand implements CommandInterface
{
    public const ALIAS = 'client';

    public function __construct(readonly private ClientInterface $chat)
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
