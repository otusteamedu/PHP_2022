<?php
/**
 * Description of RedisCacheArticleRepository.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Articles\Repositories\Cache;


use App\Models\Article;
use Redis;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Collection;

final class RedisCacheArticleRepository implements CacheArticleRepository
{
    const ARTICLE_CACHE_KEY = 'article:';
    const ARTICLES_ALL_CACHE_KEY = 'article:';
    const ARTICLE_CACHE_TTL_SEC = 300;


    private Redis $client;

    public function __construct(
        Connection $connection
    )
    {
        $this->client = $connection->client();
    }

    public function getAll(): Collection
    {
        return collect();
    }

    public function find(int $id): ?Article
    {
        $key = $this->generateArticleKey($id);
        if ($data = $this->client->get($key)) {
            $article = new Article(json_decode($data, true));
        } else {
            $article = Article::find($id);
            if (!$article) {
                return null;
            }
            $this->set($article);
        }

        return $article;
    }

    public function add(Article $article): Article
    {
        // TODO: Implement add() method.
    }

    public function forget(int $id): Article
    {
        // TODO: Implement forget() method.
    }

    public function forgetAll(): Article
    {
        // TODO: Implement forgetAll() method.
    }

    /**
     * @param Article $article
     */
    private function set(Article $article): void
    {
        $key = $this->generateArticleKey($article->id);
        $this->client->setex($key, self::ARTICLE_CACHE_TTL_SEC, json_encode($article->toArray()));
    }

    private function generateArticleKey(int $id): string
    {
        return self::ARTICLE_CACHE_KEY . $id;
    }
}
