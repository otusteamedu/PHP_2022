<?php


namespace App\Providers;


use App\Services\QueueInterfaces\ConsumerQueueInterface;
use App\Services\QueueInterfaces\PublisherQueueInterface;
use App\Services\QueueServices\RabbitConsumerQueueService;
use App\Services\QueueServices\RabbitPublisherQueueService;
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
    }
}
