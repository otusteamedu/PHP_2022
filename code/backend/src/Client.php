<?php
namespace Socket;

use Exception;
use FilesystemIterator;
use Throwable;

const USE_CMD = 'Cannot accept an empty message. Bye!';
const SERVER_DOWN_MESSAGE = 'The server went down. Bye!';
const YOUR_ID = 'Your id: ';
const YOUR_MESSAGE = 'Write your message: ';
const ERROR = 'Something went wrong. Please, try again.';

class Client extends AbstractSocket {

    private string $input;
    private SocketChat $chat;

    protected function getName(): void
    {
        $name = explode('\\', __CLASS__);
        $name = strtolower(array_pop($name));
        $this->socketName = $name . rand(100, 10000);
    }

    protected function check(): bool
    {
        return true;
    }

    protected function openLoop(): void
    {
        $this->setId();

        $this->getInput();

        $this->writeToServer();

        $this->readFromServer();

        $this->closeChat();

        $this->reOpenChat();
    }

    private function getInput(): void
    {
        $this->input = readline(
            YOUR_ID .
            $_SESSION['userId'] .
            PHP_EOL .
            YOUR_MESSAGE .
            PHP_EOL);

        if (!$this->input) {
            echo USE_CMD . PHP_EOL;
            $this->exitChat();
        }
    }

    private function writeToServer(): void
    {
        try {
            socket_set_nonblock($this->socket);
            $server = $this->config['PATH'] . $this->config['SERVER'];

            socket_clear_error();
            @socket_connect($this->socket, $server);
            @socket_write(
                $this->socket,
                json_encode(
                    [
                        'message' => $this->input,
                        'id' => $_SESSION['userId'],
                    ]
                )
            );
            if (socket_last_error()) {
                throw  new Exception();
            }
        } catch (Throwable) {
            $this->exitChat();
        }
    }

    private function readFromServer()
    {
        $result = false;
        $count = 0;
        while(!$result && $count < 10) {
            $result = socket_read($this->socket, 1024);
            if(!$result) {
                $count++;
                usleep(100);
            }
        }

        echo $result ?: ERROR;
    }

    private function removeOrphans(): void
    {
        $dummy = new Client(false);
        $dummyPath = $dummy->socketPath;

        $files = new FilesystemIterator($this->config['PATH']);

        foreach ($files as $file) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $name = explode('\\', __CLASS__);
            $name = strtolower(array_pop($name));
            if (str_contains($fileName, $name) && $fileName !== $dummyPath) {
                $dummyServer = $this->config['PATH'] . $fileName;
                try {
                    socket_clear_error();
                    socket_connect($dummy->socket , $dummyServer);
                    if (socket_last_error()) {
                        throw  new Exception();
                    }
                } catch (Throwable) {
                    if (file_exists($dummyServer)) {
                        unlink($dummyServer);
                    }
                }
            }
        }
        socket_close($dummy->socket);
        if (file_exists($dummyPath)) {
            unlink($dummyPath);
        }
    }

    private function closeChat(): void
    {
        socket_close($this->socket);
        $this->removeOrphans();
    }

    private function reOpenChat(): void
    {
        $this->chat = new SocketChat(false);
    }

    private function exitChat(): void
    {
        $this->closeChat();

        echo SERVER_DOWN_MESSAGE . PHP_EOL;
        exit;
    }
}
