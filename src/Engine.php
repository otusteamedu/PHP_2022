<?php

declare(strict_types=1);

namespace Src;

use Src\Client\Client;
use Src\Server\Server;
use Src\Services\{Configuration, ExtensionValidator, SocketService};

final class Engine
{
    private array $argv;
    private ExtensionValidator $extension_validator;
    private Configuration $configuration;

    /**
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        $this->argv = $argv;
        $this->extension_validator = new ExtensionValidator();
        $this->configuration = Configuration::getInstance();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function startChat(): void
    {
        $this->extension_validator->checkSocketExtension();

        $config = $this->configuration->getConfig();

        if ($this->argv[1] === 'server') {
            $socket_service = new SocketService(sock_file_path: $config['server_side_socket_file_path']);

            $server = new Server(configuration: $config, socket_service: $socket_service);
            $server->run();
        }

        if ($this->argv[1] === 'client') {
            $socket_service = new SocketService(sock_file_path: $config['client_side_socket_file_path']);

            $client = new Client(configuration: $config, socket_service: $socket_service);
            $client->run();
        }
    }
}
