<?php

declare(strict_types=1);

namespace Src\Services;

use Socket;
use Exception;

final class SocketService
{
    private const SUCCESSFUL_CODE = 0;
    private const SOCKET_ADDRESS_ALREADY_IN_USE_ERROR_CODE = 98;
    private const BUFFER_SOCKET_MESSAGE_MAX_LENGTH = 65536;
    private const NOT_ALLOWED_BUFFER_SOCKET_MESSAGE_LENGTH = -1;

    private string $sock_file_path;

    /**
     * @param string $sock_file_path
     */
    public function __construct(string $sock_file_path)
    {
        $this->sock_file_path = $sock_file_path;
    }

    /**
     * @return Socket
     * @throws Exception
     */
    public function createSocket(): Socket
    {
        $socket = socket_create(domain: AF_UNIX, type: SOCK_DGRAM, protocol: 0);

        if (! $socket) {
            throw new Exception(message: 'Unable to create AF_UNIX socket');
        }

        /*
         * Handling the case when the client or server is forced to exit, but the socket files remain.
         * And if so, then delete these files and re-create.
         *
         * Otherwise throw an exception.
         */
        set_error_handler(function(int $error_code, $error_message) {
            if (self::SUCCESSFUL_CODE === error_reporting()) {
                return false;
            }

            throw new Exception(message: $error_message, code: $error_code);
        });

        try {
            socket_bind($socket, $this->sock_file_path);
        } catch (\Throwable $exception) {
            $socket_error_code = socket_last_error();

            // Delete and re-create.
            if ($socket_error_code === self::SOCKET_ADDRESS_ALREADY_IN_USE_ERROR_CODE) {
                unlink(filename: $this->sock_file_path);

                socket_bind($socket, $this->sock_file_path);

                return $socket;
            }

            throw new Exception(
                message: 'Unable to bind to: ' . $this->sock_file_path . PHP_EOL
                . 'Error: ' . socket_strerror(error_code: $socket_error_code) . PHP_EOL
                . 'Exception: ' . $exception->getMessage()
            );
        }

        return $socket;
    }

    /**
     * @param Socket $socket
     * @throws Exception
     * @return array
     */
    public function receiveRequest(Socket $socket): array
    {
        if (! socket_set_block($socket)) {
            throw new Exception(message: 'Unable to set blocking mode for socket');
        }

        $buffer_message = '';
        $socket_file = '';

        // will block to wait server response
        $bytes_received = socket_recvfrom(
            socket: $socket,
            data: $buffer_message,
            length: self::BUFFER_SOCKET_MESSAGE_MAX_LENGTH,
            flags: 0,
            address: $socket_file
        );

        if ($bytes_received == self::NOT_ALLOWED_BUFFER_SOCKET_MESSAGE_LENGTH) {
            throw new Exception(message: 'An error occured while receiving from the socket');
        }

        fwrite(stream: STDOUT, data: 'Received ' . $buffer_message . ' from ' . $socket_file . PHP_EOL);

        return [
            'buffer_message' => $buffer_message,
            'socket_file' => $socket_file,
        ];
    }

    /**
     * @param Socket $socket
     * @param string $input_message
     * @param string $socket_file_path
     * @return void
     * @throws Exception
     */
    public function sendResponse(Socket $socket, string $input_message, string $socket_file_path): void
    {
        if (! socket_set_nonblock($socket)) {
            throw new Exception(message: 'Unable to set nonblocking mode for socket');
        }

        $message_length = strlen($input_message);

        // at this point 'server' process must be running and bound to receive from serv.sock
        $bytes_sent = socket_sendto(
            socket: $socket,
            data: $input_message,
            length: $message_length,
            flags: 0,
            address: $socket_file_path
        );

        if ((int) $bytes_sent === -1) {
            throw new Exception(message: 'An error occured while sending to the socket');
        } else if ((int) $bytes_sent !== $message_length) {
            throw new Exception(
                message: $bytes_sent . ' bytes have been sent instead of the ' . $message_length . ' bytes expected'
            );
        }
    }
}
