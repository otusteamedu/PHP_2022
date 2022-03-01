<?php

namespace KonstantinDmitrienko\App\Entity;

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

        while (true) {
            $socket->write(readline(Phrases::get('enter_message')));
            Phrases::show('server_response', ['{text}' => $socket->read()]);
        }
    }
}
