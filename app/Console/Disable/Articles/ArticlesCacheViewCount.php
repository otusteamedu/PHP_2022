<?php
/**
 * Description of ArticlesSyncViewCount.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Console\Commands\Articles;


use App\Models\Article;
use App\Services\Articles\Repositories\Statistics\ViewsArticleRepository;
use Illuminate\Console\Command;

class ArticlesCacheViewCount extends Command
{

    protected $signature = 'articles:views:cache';

    private function getViewsArticleRepository(): ViewsArticleRepository
    {
        return app(ViewsArticleRepository::class);
    }

    public function handle()
    {
        $this->info('Indexing all articles. This might take a while...');
        foreach (Article::cursor() as $article)
        {
//            $this->getViewsArticleRepository()->setViewsCount($article, $article->views);
            $this->output->write('.');
        }
        $this->info('\\nDone!');
    }

}
