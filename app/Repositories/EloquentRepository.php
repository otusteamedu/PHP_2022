<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository implements VideoRepositoryInterface
{
    public function search(string $query = ''): Collection
    {
        return Video::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
    }
}
