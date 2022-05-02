<?php
declare(strict_types=1);


namespace Otus\SocketApp\Infrastructure\Cli;


use Otus\SocketApp\Application\Service\LogService;
use Otus\SocketApp\Application\Service\SocketClientService;
use Otus\SocketApp\Domain\Dto\MessageDto;
use RuntimeException;

class SocketClientCommand
{
    private SocketClientService $service;

    private LogService $log;

    public function __construct()
    {
        $this->log = new LogService();
        $this->service = new SocketClientService();
    }

    public function execute(): void
    {
        $user = null;

        while (!$user) {
            echo "Введите имя пользователя или 'q' для выхода:  ";
            $user = trim(fgets(STDIN));
            if ($user === 'q') {
                throw new RuntimeException('Выход выполнен.');
            }
        }

        while (true) {
            $this->log->display('Напишите сообщение или q для выхода:');

            $message = trim(fgets(STDIN));
            if ($message === 'q') {
                throw new RuntimeException('Выход выполнен.');
            }

            if ($message !== '') {
                $dto = new MessageDto($user, $message);
                $this->service->send($dto);
            } else {
                $this->log->display('Не передавайте пустое сообщение');
            }
        }
    }
}