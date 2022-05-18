<?php

namespace Socket;

class Server extends Socket
{
    private $commonSocket;

    public function connect(): void
    {
        $this->bind();
        $this->listen();
    }

    public function run()
    {
        $this->commonSocket = $this->accept();

        while (true) {
            $message = $this->read($this->commonSocket);

            if (!$message) {
                continue;
            }

            if (trim($message) === self::EXIT_COMMAND) {
                $this->write($closeMessage);
                $this->close();
                break;
            }

            $this->write('New message received: ' . $message);
        }
    }
}