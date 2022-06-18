<?php

namespace Otus\App\Mapper;

use Otus\App\Model\Post;
use Otus\Core\Collection\CollectionInterface;

interface PostMapperInterface
{
    const TABLE_NAME = 'posts';

    public function fetchAll(): CollectionInterface;

    public function findById(int $id): ?Post;

    public function update(Post $post): void;

    public function insert(Post $domain): void;

    public function deleteById(int $id): void;

    public function createPostFromArray(array $raw): Post;
}