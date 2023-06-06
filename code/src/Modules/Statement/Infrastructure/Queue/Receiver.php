<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue;

use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Output\Log\ReceiveLogger;
use Nikcrazy37\Hw16\Modules\Statement\Domain\User;
use Nikcrazy37\Hw16\Modules\Statement\Domain\Statement;
use Nikcrazy37\Hw16\Modules\Statement\Application\StatementGenerator;

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
            array($this, "generateStatement")
        );

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->connection->close();
    }

    public function generateStatement($msg)
    {
        $data = $msg->body;
        ReceiveLogger::received($data);
        $data = json_decode($data, true);

        $statement = StatementGenerator::generate(
            new User($data["name"]),
            new Statement($data["dateFrom"], $data["dateTo"])
        );

        ReceiveLogger::done();
        $msg->ack();

        $this->telegramBot->sendMessage($statement);
    }
}