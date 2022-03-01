<?php

namespace KonstantinDmitrienko\App\Entity;

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

        echo "Waiting for incoming messages...\n\n";

        $client = $socket->accept();

        while (true) {
            $incomingData = $socket->receive($client);

            echo "Received message: \"{$incomingData['message']}\"\n";

            $response = "Received {$incomingData['bytes']} bytes";
            $socket->write($response, $client);
        }
    }
}
