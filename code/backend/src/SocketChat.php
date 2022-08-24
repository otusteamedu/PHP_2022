<?php
namespace Socket;
session_start();

class SocketChat {

    private bool $initServer;

    public function __construct(bool $initServer)
    {
        $this->initServer = $initServer;
        $this->init();
    }

    private function init(): void
    {
        $this->serverInit();
        $this->clientInit();
    }

    private function serverInit(): void
    {
        if ($this->initServer) {
            new Server();
        }
    }

    private function clientInit(): void
    {
        new Client();
    }
}
