<?php

namespace App\Providers;

use App\Services\Articles\Repositories\Cache\CacheArticleRepository;
use App\Services\Articles\Repositories\Cache\RedisCacheArticleRepository;
use App\Services\Articles\Repositories\ElasticsearchSearchSearchArticleRepository;
use App\Services\Articles\Repositories\EloquentArticleRepository;
use App\Services\Articles\Repositories\SearchArticleRepository;
use App\Services\Articles\Repositories\EloquentSearchArticleRepository;
use App\Services\Articles\Repositories\Statistics\RedisViewsArticleRepository;
use App\Services\Articles\Repositories\Statistics\ViewsArticleRepository;
use App\Services\Articles\Repositories\WriteArticleRepository;
use Elastic\Elasticsearch\ClientBuilder;
use Elasticsearch\Client as ElasticsearchClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        WriteArticleRepository::class => EloquentArticleRepository::class,
        CacheArticleRepository::class => RedisCacheArticleRepository::class,
        SearchArticleRepository::class => ElasticsearchSearchSearchArticleRepository::class,
        ViewsArticleRepository::class => RedisViewsArticleRepository::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindSearchClient();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    private function bindSearchClient()
    {
        $this->app->bind(ElasticsearchClient::class, function () {
            return ClientBuilder::create()
                ->setHosts(config('services.elasticsearch.hosts'))
                ->build();
        });
    }
}
