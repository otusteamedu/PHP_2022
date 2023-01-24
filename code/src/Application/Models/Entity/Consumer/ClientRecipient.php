<?php

namespace Otus\Mvc\Application\Models\Entity\Consumer;

use Otus\Mvc\Application\Models\Configurators\ConfiguratorRabbitMQ;
use Otus\Mvc\Domain\Models\Interface\RecipientInterface;

class ClientRecipient implements RecipientInterface
{
    public function __construct()
    {
        $connection = ConfiguratorRabbitMQ::createdChannel();
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $connection->basic_consume('message_from_race', '', false, true, false, false, $callback);

        while ($connection->is_open()) {
            $connection->wait();
        }
    }
}