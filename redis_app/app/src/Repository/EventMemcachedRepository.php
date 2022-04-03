<?php

namespace Redis\App\Repository;

class EventMemcachedRepository implements Repository
{

    public function add($model): bool
    {
        $m = new \Memcache();

    }

    public function get($request): string
    {
        // TODO: Implement get() method.
    }

    public function delete(): void
    {
        // TODO: Implement delete() method.
    }
}