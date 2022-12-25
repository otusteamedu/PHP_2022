<?php

namespace Otus\Task06\App\Commands;

use Otus\Task06\App\Chat\ChatClientManager;
use Otus\Task06\Core\Command\Command;
use Otus\Task06\Core\Container\Container;
use Otus\Task06\Core\Http\Request;
use Otus\Task06\Core\Socket\DomainSocket;

class StartClientChatCommand extends Command
{

    protected function handle(Request $request): void
    {
        $config = Container::instance()->get('config');
        $chatClientManager = new ChatClientManager( new DomainSocket($config['socket']));
        $chatClientManager->initialize();
        $chatClientManager->start();
    }
}