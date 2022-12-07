<?php

namespace Ppro\Hw7\Commands;

use Ppro\Hw7\Helper\AppContext;
use Ppro\Hw7\Sockets;

class ClientCommand extends Command
{
    /** Запуск приложения в качестве клиента
     * @param AppContext $context
     * @return void
     * @throws \Exception
     */
    public function execute(AppContext $context)
    {
        $context->setValue('type','client');
        $client = new Sockets\Client($context);
        $client->run();
    }
}