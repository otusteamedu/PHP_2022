<?php
declare(strict_types=1);


namespace Otus\SocketApp\Application\Service;


use Otus\SocketApp\Application\Config\Config;


final class SocketServerService
{
    private SocketService $service;

    private LogService $log;

    public function __construct()
    {
        $config = new Config();
        $this->log = new LogService();
        $this->service = new SocketService($config->getParam('SOCKET_FILE'));
    }

    public function __destruct()
    {
        $this->service->closeSocket(true);
    }

    public function create(): void
    {
        $this->service->create(true);

        $this->service->bind();

        $this->service->listen();

        $this->log->display('Ожидание сообщений (Для выхода нажмите CTRL+C)...');

        while (true) {
            $this->service->accept();
            $this->log->display($this->service->read());
        }
    }
}