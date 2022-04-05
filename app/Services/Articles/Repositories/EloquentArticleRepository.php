<?php
/**
 * Description of EloquentRepository.php
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace App\Services\Articles\Repositories;


use App\Models\Article;

class EloquentArticleRepository implements WriteArticleRepository
{
    public function create(array $data): int
    {
        return Article::create($data)->id;
    }

    public function update(int $id, array $data): void
    {
        Article::find($id)->update($data);
    }


}
