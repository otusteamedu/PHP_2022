<?php
declare(strict_types=1);


namespace Otus\SocketApp\Application\Service;


use http\Exception\RuntimeException;
use Otus\SocketApp\Application\Config\Config;
use Otus\SocketApp\Domain\Interface\MessageDtoInterface;

final class SocketClientService
{
    private SocketService $service;

    public function __construct()
    {
        $config = new Config();
        $this->service = new SocketService($config->getParam('SOCKET_FILE'));
    }

    public function send(MessageDtoInterface $dto): void
    {
        $this->service->create();

        if ($this->service->connect() === false) {
            throw new RuntimeException('Не удалось подключиться к сокету');
        }

        $this->service->send("{$dto->getUser()}: {$dto->getMessage()}");
    }
}