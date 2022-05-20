<?php

namespace Socket;

class Server
{
    private ?Socket $commonSocket;
    private $phpSocket;

    /**
     * @throws
     */
    public function __construct(
        array $config
    ) {
        $this->commonSocket = new Socket($config);
    }

    public function run(): void
    {
        $this->phpSocket = $this->commonSocket->accept();

        while (true) {
            $message = $this->commonSocket->read($this->phpSocket);

            if (!$message) {
                continue;
            }

            if (trim($message) === Socket::EXIT_COMMAND) {
                $this->close();
                break;
            }

            $this->commonSocket->write('New message received: ' . $message);
        }
    }

    public function connect(): void
    {
        if (!$this->commonSocket) {
            $this->commonSocket->create();
        }

        $this->commonSocket->bind();
        $this->commonSocket->listen();
    }

    public function close()
    {
        $this->commonSocket->close($this->phpSocket);
    }
}