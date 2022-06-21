<?php

namespace Otus\App\Mapper;

use Otus\App\Model\Post;
use Otus\Core\Collection\CollectionInterface;
use Otus\Core\Database\DomainWatcher;
use Otus\Core\Database\Exception\DomainWatchException;

class PostMapperIdentityMap implements PostMapperInterface
{
    public string $table;

    public function __construct(
        private readonly PostMapperInterface $mapper
    )
    {
    }

    public function fetchAll(): CollectionInterface
    {
        return $this->mapper->fetchAll();
    }

    public function findById(int $id): ?Post
    {
        try {
            return DomainWatcher::getByClassAndId(Post::class, $id);
        } catch (DomainWatchException) {
            return $this->mapper->findById($id);
        }
    }

    public function update(Post $post): void
    {
        $this->mapper->update($post);
    }

    public function insert(Post $post): void
    {
        $this->mapper->insert($post);
        DomainWatcher::add($post);
    }

    public function deleteById(int $id): void
    {
        $this->mapper->deleteById($id);
        DomainWatcher::deleteByClassAndId(Post::class, $id);
    }

    public function createPostFromArray(array $raw): Post
    {
        $post = DomainWatcher::getByClassAndId(Post::class, $raw['id']);
        if ($post instanceof Post) {
            return $post;
        }
        $post = $this->mapper->createPostFromArray($raw);
        DomainWatcher::add($post);
        return $post;
    }
}