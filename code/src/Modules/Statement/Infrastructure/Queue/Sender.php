<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue;

use PhpAmqpLib\Message\AMQPMessage;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Output\Log\SendLogger;
use Nikcrazy37\Hw16\Modules\Statement\Domain\Statement;
use Nikcrazy37\Hw16\Modules\Statement\Domain\User;

class Sender extends Builder
{
    public function execute(User $user, Statement $statement): void
    {
        $data = $this->getData($user, $statement);
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        $this->sendMessage($data);

        $this->connection->close();
    }

    private function getData(User $user, Statement $statement): array
    {
        return array(
            "name" => $user->getName(),
            "date" => $statement->getDate()
        );
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