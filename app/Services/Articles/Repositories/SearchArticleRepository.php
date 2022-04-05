<?php
/**
 * Description of ArticleRepository.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Services\Articles\Repositories;


use App\Models\Article;
use Illuminate\Support\Collection;

interface SearchArticleRepository
{

    public function search(string $q, int $limit, int $offset): Collection;

}
