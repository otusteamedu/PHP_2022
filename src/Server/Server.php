<?php

declare(strict_types=1);

namespace Src\Server;

use Socket;
use Src\Services\SocketService;

final class Server
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

        while (true)
        {
            fwrite(stream: STDOUT, data: 'Ready to receive...' . PHP_EOL);

            $receive_data = $this->socket_service->receiveRequest(socket: $socket);

            if ($receive_data['buffer_message'] === 'close:connection') {
                $this->stop(socket: $socket);

                return;
            }

            $this->socket_service->sendResponse(
                socket: $socket,
                input_message: $receive_data['buffer_message'],
                socket_file_path: $receive_data['socket_file']
            );
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

        unlink($this->configuration['server_side_socket_file_path']);

        fwrite(stream: STDOUT, data: 'Server stopped' . PHP_EOL);
    }
}
