<?php

namespace Ppro\Hw7\Commands;

use Ppro\Hw7\Sockets;
use Ppro\Hw7\Helper\AppContext;

class ServerCommand extends Command
{
    /** Запуск приложения в качестве сервера
     * @param AppContext $context
     * @return void
     * @throws \Exception
     */
    public function execute(AppContext $context): void
    {
        $context->setValue('type','server');
        $server = new Sockets\Server($context);
        $server->run();
    }
}