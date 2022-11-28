<?php

namespace Koptev\Hw6;

use Exception;

class Client extends Socket
{
    protected string $serverFile;

    /**
     * @param array $configClient
     * @param array $configServer
     * @throws Exception
     */
    public function __construct(array $configClient, array $configServer)
    {
        parent::__construct($configClient);

        if (!empty($configServer)) {
            $this->serverFile = $this->getFile($configServer['file'], false);
        }

        $this->setNonBlock();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $handle = fopen ("php://stdin","r");

        while (true) {
            $message = trim(fgets($handle));

            $this->send($message, $this->serverFile);

            $this->setBlock();

            $received = $this->receive();

            fwrite($handle, $received->text . PHP_EOL);
        }
    }
}
