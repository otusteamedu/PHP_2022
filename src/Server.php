<?php

namespace Koptev\Hw6;

use Exception;

class Server extends Socket
{
    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $handle = fopen ("php://stdout","w");

        while(true) {
            $received = $this->receive();

            fwrite($handle, $received->text . PHP_EOL);

            $this->setBlock();

            $clientMessage = "Received $received->bytes bytes";

            $this->send($clientMessage, $received->address);
        }
    }
}
