<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Queue;

use PhpAmqpLib\Message\AMQPMessage;
use Nikcrazy37\Hw20\Infrastructure\Output\Log\SendLogger;

class Sender extends Builder
{
    public function execute(string $uid): void
    {
        $data = json_encode($uid, JSON_UNESCAPED_UNICODE);

        $this->sendMessage($data);

        $this->connection->close();
    }

    private function sendMessage($data): void
    {
        $msg = new AMQPMessage(
            $data,
            array("delivery_mode" => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        SendLogger::sent($data);

        $this->channel->basic_publish(
            $msg,
            "",
            "task_queue"
        );
    }
}