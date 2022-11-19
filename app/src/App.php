<?php

declare(strict_types=1);

namespace Eliasjump\UnixChat;

use Exception;

class App
{
    private string $type;

    public function __construct() {
        $this->type = $_SERVER['argv'][1] ?? '';
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        match ($this->type) {
            'server' => (new Server())->run(),
            'client' => (new Client())->run(),
            default => throw new Exception('Неизвестный флаг. Укажите тип: server или client')
        };
    }
}