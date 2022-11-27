<?php

declare(strict_types=1);

namespace App\Chat\Command;

use App\Chat\Service\MessageGenerator;

class Server implements ExecutableInterface
{
    /**
     * @var resource
     */
    private $server;

    private string $socketFilePath;

    private int $timeout;

    public function __construct(array $options)
    {
        $socketFilePath = $options['socketFilePath'] ?? null;
        $timeout = $options['timeout'] ?? 30;
        if (\is_null($socketFilePath) || !\is_numeric($timeout)) {
            throw new \RuntimeException('Таймаут или/и путь до сокет файла не определены в конфигурации');
        }

        // запускаем сокет сервер
        $server = \stream_socket_server('unix://' . $socketFilePath, $errorCode, $errorMsg);
        if (!$server) {
            throw new \RuntimeException(sprintf('Не удалось создать клиент: код ошибки %s, текст %s', $errorCode, $errorMsg));
        }

        $this->socketFilePath = $socketFilePath;
        $this->timeout = \intval($timeout);
        $this->server = $server;
    }

    public function execute(): void
    {
        // Флаг, показывающий, были ли отправлено приветственное сообщение клиенту при первом подключении или нет
        $greetingMessageSent = false;
        while ($conn = stream_socket_accept($this->server, $this->timeout)) {
            // отправляем приветственное сообщение клиенту
            if (!$greetingMessageSent) {
                fwrite($conn, MessageGenerator::makeGreeting());
                $greetingMessageSent = true;
            }

            // получаем сообщение от клиента
            echo 'Сообщение от клиента: ' . \fread($conn, 1024) . PHP_EOL;
            // отвечает клиенту и закрываем соединение
            \fwrite($conn, 'Спасибо за сообщение, рандомная фраза в подарок: ' . MessageGenerator::makeAction());
            \fclose($conn);
        }
        $this->closeSocketServer();
    }

    private function closeSocketServer()
    {
        \fclose($this->server);
        \unlink($this->socketFilePath);
    }
}