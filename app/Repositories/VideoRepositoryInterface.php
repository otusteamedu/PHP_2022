<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface VideoRepositoryInterface
{
    public function search(string $query = ''): Collection;
}
