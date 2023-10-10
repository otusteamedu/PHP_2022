<?php

declare(strict_types=1);

namespace App\Infrastructure\Chat\SocketMode;

use App\Application\Chat\ClientInterface;
use App\Application\Message\MessageBuilder;
use Exception;

class Client extends Chat implements ClientInterface
{
    /**
     * @throws Exception
     */
    public function start(): void
    {
        parent::start();

        echo "Type 'exit' to stop server & exit\n";

        $this->checkOtherSide();

        do {
            $messageBody = readline($this->mode->name . ": ");

            if ($messageBody) {
                $this->sendMessage(MessageBuilder::build($messageBody));
            }

            $answer = $this->getMessage();

            if (!empty($answer->getBody())) {
                echo $this->mode->getOtherSide()->name . ': ' . $answer->getBody() . PHP_EOL;
            }
        } while ($messageBody !== 'exit');
    }

    /**
     * @throws Exception
     */
    public function checkOtherSide(): void
    {
        socket_connect($this->socket, $this->otherSideFullPath) or
        throw new Exception("First start the {$this->mode->getOtherside()->name}\n");
    }
}
