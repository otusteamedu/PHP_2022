<?php

declare(strict_types=1);
namespace Mapaxa\SocketChatApp\App;

class App
{
    public function execute(): void
    {
        $appFactory = AppFactory::createApp();
        $appFactory->execute();
    }
}