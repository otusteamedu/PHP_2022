<?php

namespace App\Providers;

use App\Services\Interfaces\ConsumerQueueInterface;
use App\Services\Interfaces\PublisherQueueInterface;
use App\Services\QueueServices\RabbitConsumerQueueService;
use App\Services\QueueServices\RabbitPublisherQueueService;
use App\Services\ReportHandlers\ReportExecuteHandler;
use App\Services\Interfaces\ReportExecuteHandlerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PublisherQueueInterface::class, RabbitPublisherQueueService::class);
        $this->app->bind(ConsumerQueueInterface::class, RabbitConsumerQueueService::class);
        $this->app->bind(ReportExecuteHandlerInterface::class, ReportExecuteHandler::class);
    }
}
