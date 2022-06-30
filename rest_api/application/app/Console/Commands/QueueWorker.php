<?php

namespace App\Console\Commands;

use App\RabbitMQ\Consumer;
use Illuminate\Console\Command;

class QueueWorker extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'worker:run';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Создать новый экземпляр команды.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Consumer $consumer)
    {
        $consumer->read('tasks');
    }
}
