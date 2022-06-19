<?php

namespace Otus\App\Mapper;

use Otus\App\Model\Post;
use Otus\Core\Collection\Collection;
use Otus\Core\Database\Mapper\BaseMapper;
use Otus\App\Factory\CommentMapperFactory;
use Otus\Core\Collection\CollectionInterface;

class PostMapper implements PostMapperInterface
{
    public string $table;

    public function __construct(
        private readonly BaseMapper $mapper,
    )
    {
        $this->table = 'posts';
    }

    public function fetchAll(): CollectionInterface
    {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $rawData = $this->mapper->fetchAll($query);
        $collection = new Collection($rawData);
        $collection->handleItem(fn($item) => $this->createPostFromArray($item));
        return $collection;
    }

    public function findById(int $id): ?Post
    {
        $query = "SELECT * FROM {$this->table} WHERE id=? ORDER BY id DESC LIMIT 1";
        $rawData = $this->mapper->fetch($query, [$id]);
        return is_array($rawData) ? $this->createPostFromArray($rawData) : null;
    }

    public function update(Post $post): void
    {
        $query = "UPDATE {$this->table} SET title=? WHERE id=?";
        $this->mapper->executeQuery([
            $post->getTitle(),
            $post->getId(),
        ], $query);
    }

    public function insert(Post $domain): void
    {
        $query = "INSERT INTO {$this->table} (title) VALUES (?)";
        $this->mapper->executeQuery([
            $domain->getTitle(),
        ], $query);
        $id = $this->mapper->getLastInsertId();
        $commentMapper = CommentMapperFactory::make();
        $comments = $commentMapper->deferFindByPostId($id);
        $domain->setComments($comments);
        $domain->setId($id);
    }

    public function deleteById(int $id): void
    {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $this->mapper->executeQuery([$id], $query);
    }

    public function createPostFromArray(array $raw): Post
    {
        $post = new Post();
        isset($raw['id']) && $post->setId($raw['id']);
        isset($raw['title']) && $post->setTitle($raw['title']);
        $commentMapper = CommentMapperFactory::make();
        $comments = $commentMapper->deferFindByPostId($post->getId());
        $post->setComments($comments);
        return $post;
    }
}