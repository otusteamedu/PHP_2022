<?php
/**
 * Description of ShowArticle.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Services\Articles\Handlers;


use App\Models\Article;
use App\Services\Articles\Repositories\Cache\CacheArticleRepository;
use App\Services\Articles\Repositories\SearchArticleRepository;
use App\Services\Articles\Repositories\Statistics\ViewsArticleRepository;

class ShowArticleHandler
{

    private ViewsArticleRepository $viewsArticleRepository;
    private CacheArticleRepository $cacheArticleRepository;

    public function __construct(
        ViewsArticleRepository $viewsArticleRepository,
        CacheArticleRepository $cacheArticleRepository
    )
    {

        $this->viewsArticleRepository = $viewsArticleRepository;
        $this->cacheArticleRepository = $cacheArticleRepository;
    }

    public function handle(int $id, string $userKey): ?Article
    {
        $article = $this->cacheArticleRepository->find($id);
        if (!$article) {
            return null;
        }

        $this->viewsArticleRepository->incViewsCount($id, $userKey);
        return $article;
    }

}
