<?php
declare(strict_types=1);


namespace Otus\SocketApp\Infrastructure\Cli;


use Exception;
use Otus\SocketApp\Application\Service\SocketServerService;

class SocketServerCommand
{
    private SocketServerService $service;

    public function __construct()
    {
        $this->service = new SocketServerService();
    }

    public function execute(): void
    {
        try {
            $this->service->create();
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}