<?php

declare(strict_types=1);

namespace App\Chat\Command;

class Client implements ExecutableInterface
{
    /**
     * @var resource
     */
    private $client;

    private string $socketFilePath;
    private mixed $timeout;

    public function __construct(array $options)
    {
        $socketFilePath = $options['socketFilePath'] ?? null;
        $timeout = $options['timeout'] ?? 30;
        if (\is_null($socketFilePath) || !\is_numeric($timeout)) {
            throw new \RuntimeException('Таймаут или/и путь до сокет файла не определены в конфигурации');
        }
        $this->socketFilePath = $socketFilePath;
        $this->timeout = \intval($timeout);
    }

    public function execute(): void
    {
        // флаг для первого соединения, чтобы получить приветственное сообщение от сервера
        $isInitial = true;
        while (true) {
            // создаем клиент
            $client = stream_socket_client(
                'unix://' . $this->socketFilePath,
                $errorCode,
                $errorMsg,
                $this->timeout
            );
            if (!$client) {
                throw new \RuntimeException(sprintf('Не удалось создать клиент: код ошибки %s, текст %s', $errorCode, $errorMsg));
            }

            // получаем приветственное от сервера (выполняется один раз при запуске)
            if ($isInitial) {
                echo \fread($client, 1024) . PHP_EOL;
                $isInitial =false;
            }

            // отправляем серверу текст из инпута
            $input = \readline('Введите сообщение для сервера: ');
            if (\strtolower($input) === 'exit') {
                break;
            }
            fwrite($client, $input);

            // читаем, что пришло в ответ и закрываем соединение
            echo \fread($client, 1024) . PHP_EOL;
            fclose($client);
        }
    }
}