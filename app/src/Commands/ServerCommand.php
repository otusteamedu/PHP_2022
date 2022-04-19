<?php

namespace Nka\OtusSocketChat\Commands;

use Nka\OtusSocketChat\Services\SocketServerService;

class ServerCommand extends AbstractInvokeCommand
{
    public function __construct(
        protected SocketServerService $service
    )
    {}


    protected function run()
    {
        $this->service->listen();
    }
}