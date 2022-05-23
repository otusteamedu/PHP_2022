<?php
declare(strict_types=1);


namespace Otus\SocketApp\Application\Service;


use http\Exception\RuntimeException;
use Otus\SocketApp\Application\Config\Config;

final class SocketClientService
{
    private SocketService $service;

    public function __construct()
    {
        $config = new Config();
        $this->service = new SocketService($config->getParam('SOCKET_FILE'));
    }

    public function send(string $user, string $message): void
    {
        $this->service->create();

        if ($this->service->connect() === false) {
            throw new RuntimeException('Не удалось подключиться к сокету');
        }

        $this->service->send("{$user}: {$message}");
    }
}