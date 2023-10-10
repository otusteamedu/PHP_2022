<?php

declare(strict_types=1);

namespace App\Infrastructure\Chat\SocketMode;

use App\Application\Chat\ServerInterface;
use App\Application\Message\MessageBuilder;
use Exception;

class Server extends Chat implements ServerInterface
{
    /**
     * @throws Exception
     */
    public function start(): void
    {
        parent::start();

        echo "Waiting for messages...\n";
        do {
            $message = $this->getMessage();

            if (!empty($message->getBody())) {
                echo $this->mode->getOtherSide()->name . ': ' . $message->getBody() . PHP_EOL;
                $this->sendMessage(MessageBuilder::build(mb_strlen($message->getBody()) . ' bytes received'));
            }
        } while ($message->getBody() !== 'exit');
    }
}
