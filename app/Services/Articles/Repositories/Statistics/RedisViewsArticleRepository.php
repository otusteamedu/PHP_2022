<?php
/**
 * Description of RedisViewsArticleRepository.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Services\Articles\Repositories\Statistics;

use Redis;
use Illuminate\Redis\Connections\Connection;

class RedisViewsArticleRepository implements ViewsArticleRepository
{
    private Redis $redis;

    const ARTICLES_VIEWS_COUNT_KEY_PREFIX = 'articles:views:';

    public function __construct(
        Connection $redisConnection
    )
    {
        $this->redis = $redisConnection->client();
    }


    public function incViewsCount(int $article, string $userKey): void
    {
        $key = $this->generateKey($article);
        $this->redis->sAdd($key, $userKey);
    }

    public function getViewsCount(int $article): int
    {
        $key = $this->generateKey($article);
        return $this->redis->sCard($key) ?: 0;
    }

    private function generateKey(int $article): string
    {
        return self::ARTICLES_VIEWS_COUNT_KEY_PREFIX . $article;
    }

}
