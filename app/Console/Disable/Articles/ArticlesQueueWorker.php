<?php
/**
 * Description of ArticlesQueueWorker.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Console\Commands\Articles;


use App\Models\Article;
use App\Services\Articles\ArticleService;
use App\Services\Articles\Handlers\ReindexArticleHandler;
use App\Services\Queues\RedisSimpleQueue;
use Illuminate\Console\Command;

class ArticlesQueueWorker extends Command
{

    protected $signature = 'articles:queue:worker';

    private RedisSimpleQueue $redisSimpleQueue;
    private ReindexArticleHandler $reindexArticleHandler;

    public function __construct(
        RedisSimpleQueue $redisSimpleQueue,
        ReindexArticleHandler $reindexArticleHandler
    )
    {
        parent::__construct();

        $this->redisSimpleQueue = $redisSimpleQueue;
        $this->reindexArticleHandler = $reindexArticleHandler;
    }

    public function handle()
    {
        $data = $this->redisSimpleQueue->pop(ArticleService::ARTICLES_UPDATED_QUEUE);
        $id = json_decode($data)['id'];
        if (!$id) {
            return;
        }
        $article = Article::find($id);
        $this->reindexArticleHandler->handle($article);
    }

}
