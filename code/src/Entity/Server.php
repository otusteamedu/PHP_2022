<?php

namespace KonstantinDmitrienko\App\Entity;

use KonstantinDmitrienko\App\Phrases;

/**
 * Class for getting incoming messages
 */
class Server
{
    /**
     * @param $socket
     *
     * @return void
     */
    public function listen($socket): void
    {
        $socket->bind();
        $socket->listen();

        Phrases::show('waiting_messages');

        $client = $socket->accept();

        while (true) {
            $incomingData = $socket->receive($client);

            Phrases::show('received_message', ['{message}' => $incomingData['message']]);

            $socket->write(Phrases::get('received_bytes', ['{bytes}' => $incomingData['bytes']]), $client);
        }
    }
}
