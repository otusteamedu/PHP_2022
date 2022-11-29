<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Application\EventStorage\Contracts\EventStorageInterface;
use App\Application\EventStorage\Services\RedisClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind(EventStorageInterface::class, RedisClient::class);
    }
}
