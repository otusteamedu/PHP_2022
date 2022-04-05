<?php
/**
 * Description of CacheArticleRepository.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Articles\Repositories\Cache;


use App\Models\Article;
use Illuminate\Support\Collection;

interface CacheArticleRepository
{

    public function getAll(): Collection;
    public function find(int $id): ?Article;
    public function add(Article $article): Article;

    public function forget(int $id): Article;
    public function forgetAll(): Article;

}
