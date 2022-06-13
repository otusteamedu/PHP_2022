<?php


namespace App\Console\Commands;


use App\Services\RabbitConsumerQueueService;
use ErrorException;
use Illuminate\Console\Command;

class RabbitCommand extends Command
{
    protected $signature = 'rabbit';

    protected $description = 'List rabbitMQ queue pushed tasks';

    /**
     * @throws ErrorException
     */
    public function handle(): void
    {
        $this->info('start listening rabbitMq queue.');

        $service = new RabbitConsumerQueueService();

        $service->handle();
    }
}
