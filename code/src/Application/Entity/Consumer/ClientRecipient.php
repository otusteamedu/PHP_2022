<?php

namespace Otus\App\Application\Entity\Consumer;

use Otus\App\Application\Entity\Configurator;
use Otus\App\Domain\Models\Interface\RecipientInterface;

/**
 * Queue listener
 */
class ClientRecipient implements RecipientInterface
{
    /**
     * Run listener
     */
    public function __construct()
    {
        $connection = Configurator::createdChannel();
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $connection->basic_consume('message_from_bank', '', false, true, false, false, $callback);

        while ($connection->is_open()) {
            $connection->wait();
        }
    }
}
