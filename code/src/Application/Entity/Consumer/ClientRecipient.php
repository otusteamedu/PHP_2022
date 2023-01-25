<?php

namespace Otus\App\Application\Entity\Consumer;

use Otus\App\Application\Entity\Configurator;
use Otus\App\Domain\Models\Interface\RecipientInterface;

/**
 * Queue listener
 */
class ClientRecipient implements RecipientInterface
{
    private $connection;

    /**
     * Init listener
     */
    public function __construct()
    {
        $this->connection = Configurator::createdChannel();
        $callback = function ($msg) {
            echo " [x] Received ", $msg->body, "\n";
        };

        $this->connection->basic_consume('message_from_bank', '', false, true, false, false, $callback);
    }

    /**
     * Run messages listening
     * @return void
     */
    public function getMessage()
    {
        while ($this->connection->is_open()) {
            $this->connection->wait();
        }
    }
}
