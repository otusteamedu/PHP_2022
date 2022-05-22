<?php
declare(strict_types=1);


namespace Otus\SocketApp\Infrastructure\Cli;


use Otus\SocketApp\Application\Service\DisplayService;
use Otus\SocketApp\Application\Service\SocketClientService;
use Otus\SocketApp\Domain\Dto\MessageDto;
use RuntimeException;

class SocketClientCommand
{
    private SocketClientService $service;

    private DisplayService $display;

    public function __construct()
    {
        $this->display = new DisplayService();
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
            $this->display->info('Напишите сообщение или q для выхода:');

            $message = trim(fgets(STDIN));
            if ($message === 'q') {
                throw new RuntimeException('Выход выполнен.');
            }

            if ($message !== '') {
                $this->service->send($user, $message);
            } else {
                $this->display->info('Не передавайте пустое сообщение');
            }
        }
    }
}