<?php
namespace Socket;

use Exception;
use Throwable;

const SERVER_READY = ' is ready';
const CLIENT_WROTE = 'A client wrote: ';
const YOU_WROTE = 'You wrote: ';
const YOUR_ANSWER = 'The answer: ';
const SERVER_ID = 'Server id: ';
const CLIENT_ID = 'Client id: ';

class Server extends AbstractSocket {

    protected function check(): bool
    {
        $dummy = new Client(false);
        $server = $this->config['PATH'] . $this->socketName;
        try {
            if (file_exists($server)) {
                socket_clear_error();
                if (@socket_connect($dummy->socket , $server)) {
                    socket_close($dummy->socket);
                    if (file_exists($dummy->socketPath)) {
                        unlink($dummy->socketPath);
                    }
                    return false;
                }
                if (socket_last_error()) {
                    throw  new Exception();
                }
            }
        } catch (Exception) {
            if (file_exists($server)) {
                unlink($server);
            }
        }
        socket_close($dummy->socket);
        if (file_exists($dummy->socketPath)) {
            unlink($dummy->socketPath);
        }
        return true;
    }

    protected function getName(): void
    {
        $name = explode('\\', __CLASS__);
        $name = strtolower(array_pop($name));
        $this->socketName = $name;
    }

    protected function openLoop(): void
    {
        $this->setId();

        socket_bind($this->socket, $this->socketPath);
        socket_listen($this->socket);
        socket_set_nonblock($this->socket);

        echo SERVER_ID . $_SESSION['userId'] . SERVER_READY . ' NOW' . PHP_EOL;

        while(true)
        {
            if(($client = socket_accept($this->socket)) !== false)
            {
                $received =
                    json_decode(
                        socket_read($client, 2048),
                        true
                    );

                if ($received && count($received) && $received['message']) {
                    echo PHP_EOL;
                    echo CLIENT_WROTE . $received['message'] . ', ' . CLIENT_ID . $received['id']. PHP_EOL;
                    $response = YOU_WROTE . $received['message'] . PHP_EOL;
                    $response .= YOUR_ANSWER . $this->getReply() . PHP_EOL;
                    $response .= PHP_EOL;

                    try {
                        socket_clear_error();
                        @socket_write($client,  $response);
                        if (socket_last_error()) {
                            throw  new Exception();
                        }
                    } catch (Throwable $e) {
                        echo $e->getMessage();
                    }

                    echo SERVER_ID . $_SESSION['userId'] . SERVER_READY . ' AGAIN' . PHP_EOL;
                }
            }
        }
    }

    private function getReply(): string
    {
        $string = '';
        $vowels = array('a', 'e', 'i', 'o', 'u');
        $consonants = array(
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z',
        );
        $max = rand(6, 18);
        for ($i = 1; $i <= $max; $i++) {
            $string .= $consonants[rand(0, 19)];
            if ($i === 1) {
                $string = mb_strtoupper($string);
            }
            $string .= $vowels[rand(0, 4)];
            if (!rand(0, 4)) {
                $string .= ' ';
            }
        }
        $string = trim($string);
        return rand(0, 4) ? $string . '.' : (rand(0, 2) ? $string . '!' : $string . '?');
    }
}
