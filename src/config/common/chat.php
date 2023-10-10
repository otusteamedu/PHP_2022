<?php

declare(strict_types=1);

use App\Application\Chat\ClientInterface;
use App\Application\Chat\Mode;
use App\Application\Chat\ServerInterface;
use App\Infrastructure\Chat\SocketMode\Client;
use App\Infrastructure\Chat\SocketMode\Server;
use Psr\Container\ContainerInterface;

return [
    ClientInterface::class => static function (ContainerInterface $container): Client {
        return new Client($container->get('config')['socket_dir'], Mode::CLIENT);
    },
    ServerInterface::class => static function (ContainerInterface $container): Server {
        return new Server($container->get('config')['socket_dir'], Mode::SERVER);
    },
];
