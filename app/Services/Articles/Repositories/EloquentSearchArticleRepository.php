<?php
/**
 * Description of EloquentArticleRepository.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Services\Articles\Repositories;


use App\Models\Article;
use Illuminate\Support\Collection;

class EloquentSearchArticleRepository implements SearchArticleRepository
{

    public function search(string $q, int $limit, int $offset): Collection
    {
        $qb = Article::query();
        if ($q) {
            $qb->where('body', 'like', "%{$q}%");
            $qb->orWhere('title', 'like', "%{$q}%");
        }
        $qb->take($limit);
        $qb->skip($offset);

        return $qb->get();
    }


}
