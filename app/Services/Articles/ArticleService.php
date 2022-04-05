<?php
/**
 * Description of ArticleService.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Services\Articles;


use App\Models\Article;
use App\Services\Articles\Handlers\ShowArticleHandler;
use App\Services\Articles\Repositories\SearchArticleRepository;
use App\Services\Articles\Repositories\WriteArticleRepository;
use App\Services\Queues\RedisSimpleQueue;
use Illuminate\Support\Collection;

class ArticleService
{

    const ARTICLES_UPDATED_QUEUE = 'articles:updated';

    private SearchArticleRepository $articleRepository;
    private ShowArticleHandler $showArticleHandler;
    /**
     * @var WriteArticleRepository
     */
    private WriteArticleRepository $writeArticleRepository;
    /**
     * @var RedisSimpleQueue
     */
    private RedisSimpleQueue $redisSimpleQueue;

    public function __construct(
        WriteArticleRepository $writeArticleRepository,
        ShowArticleHandler $showArticleHandler,
        SearchArticleRepository $articleRepository,
        RedisSimpleQueue $redisSimpleQueue
    )
    {
        $this->articleRepository = $articleRepository;
        $this->showArticleHandler = $showArticleHandler;
        $this->writeArticleRepository = $writeArticleRepository;
        $this->redisSimpleQueue = $redisSimpleQueue;
    }

    public function showArticle(int $id, string $userKey): ?Article
    {
        return $this->showArticleHandler->handle($id, $userKey);
    }

    public function search(string $q, int $limit, int $offset): Collection
    {
        return $this->articleRepository->search($q, $limit, $offset);
    }

    public function updateArticle(
        int $id,
        array $data
    ): void
    {
        $this->writeArticleRepository->update($id, $data);

        $this->redisSimpleQueue->push(self::ARTICLES_UPDATED_QUEUE, json_encode([
            'id' => $id,
        ]));
    }

}
