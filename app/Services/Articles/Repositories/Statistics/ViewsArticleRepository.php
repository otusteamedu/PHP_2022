<?php
/**
 * Description of ViewsArticleRepository.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Services\Articles\Repositories\Statistics;


interface ViewsArticleRepository
{

    public function getViewsCount(int $article): int;
    public function incViewsCount(int $article, string $userKey): void;

}
