<?php

namespace KonstantinDmitrienko\App\CommandControllers;

use KonstantinDmitrienko\App\Phrases;

/**
 * Class for sending outgoing messages
 */
class Client
{
    /**
     * @param $socket
     *
     * @return void
     */
    public function sendMessage($socket): void
    {
        $socket->connect();
        Phrases::show('client_start_chat', ['{exit}' => $socket->exitCommand]);

        while (true) {
            $message = readline(Phrases::get('enter_message'));

            $socket->write($message);

            if ($message === $socket->exitCommand) {
                Phrases::show('client_finish_chat');
                $socket->close();
                break;
            }

            Phrases::show('server_response', ['{text}' => $socket->read()]);
        }
    }
}
