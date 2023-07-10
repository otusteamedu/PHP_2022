<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Queue;

use Nikcrazy37\Hw20\Infrastructure\Output\Log\ReceiveLogger;
use Nikcrazy37\Hw20\Application\Request\ProcessRequest;

class Receiver extends Builder
{
    public function run()
    {
        ReceiveLogger::waiting();

        $this->channel->basic_qos(
            null,
            1,
            null
        );
        $this->channel->basic_consume(
            "task_queue",
            "",
            false,
            false,
            false,
            false,
            array($this, "saveRequest")
        );

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->connection->close();
    }

    public function saveRequest($msg)
    {
        $data = $msg->body;
        ReceiveLogger::received($data);
        $data = json_decode($data, true);

        ($this->container->get(ProcessRequest::class))->changeStatus($data);

        ReceiveLogger::done();
        $msg->ack();
    }
}