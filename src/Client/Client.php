<?php

declare(strict_types=1);

namespace Src\Client;

use Socket;
use Src\Services\SocketService;

final class Client
{
    private SocketService $socket_service;
    private array $configuration;

    /**
     * @param array $configuration
     * @param SocketService $socket_service
     */
    public function __construct(array $configuration, SocketService $socket_service)
    {
        $this->socket_service = $socket_service;
        $this->configuration = $configuration;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $socket = $this->socket_service->createSocket();

        while (true) {
            $msg = trim(fgets(stream: STDIN));

            if (in_array(needle: $msg, haystack: ['stop', 'close:connection'])) {
                if ($msg === 'close:connection') {
                    $this->socket_service
                        ->sendResponse(
                            socket: $socket,
                            input_message: $msg,
                            socket_file_path: $this->configuration['server_side_socket_file_path']
                        );
                }

                $this->stop(socket: $socket);

                return;
            }

            $this->socket_service
                ->sendResponse(
                    socket: $socket,
                    input_message: $msg,
                    socket_file_path: $this->configuration['server_side_socket_file_path']
                );

            $this->socket_service->receiveRequest(socket: $socket);
        }
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @param Socket $socket
     * @return void
     */
    private function stop(Socket $socket): void
    {
        socket_shutdown(socket: $socket);
        socket_close(socket: $socket);

        unlink($this->configuration['client_side_socket_file_path']);

        fwrite(stream: STDOUT, data: 'Client closed' . PHP_EOL);
    }
}
