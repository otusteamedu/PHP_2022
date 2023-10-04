<?php

declare(strict_types=1);

use App\Chat\ChatInterface;
use App\Chat\SocketChat\Chat;
use Psr\Container\ContainerInterface;

return [
    ChatInterface::class => static function (ContainerInterface $container): Chat {
        return new Chat($container->get('config')['socket_dir']);
    },
];
