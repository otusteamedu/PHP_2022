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

class ArticlesSyncViewCount extends Command
{

    protected $signature = 'articles:views:sync';
    /**
     * @var ViewsArticleRepository
     */
    private ViewsArticleRepository $viewsArticleRepository;

    public function __construct(
        ViewsArticleRepository $viewsArticleRepository
    )
    {
        parent::__construct();
        $this->viewsArticleRepository = $viewsArticleRepository;
    }


    public function handle()
    {
        $this->info('Indexing all articles. This might take a while...');
        foreach (Article::cursor() as $article)
        {
            $viewsCount = $this->viewsArticleRepository->getViewsCount($article);
            $article->update([
                'views' => $viewsCount,
            ]);
            $this->output->write('.');
        }
        $this->info('\\nDone!');
    }

}
