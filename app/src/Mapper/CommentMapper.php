<?php

namespace Otus\App\Mapper;

use Otus\App\Model\Comment;
use Otus\Core\Collection\Collection;
use Otus\Core\Collection\CollectionInterface;
use Otus\Core\Collection\DeferCollection;
use Otus\Core\Database\Mapper\BaseMapper;

class CommentMapper implements CommentMapperInterface
{
    public readonly string $table;

    public function __construct(
        private readonly BaseMapper $mapper,
    )
    {
        $this->table = 'comments';
    }

    public function fetchAll(): CollectionInterface
    {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $rawData = $this->mapper->fetchAll($query);
        $collection = new Collection($rawData);
        $collection->handleItem(fn($item) => $this->createCommentFromArray($item));
        return $collection;
    }

    public function findByPostId(int $id): CollectionInterface
    {
        $query = "SELECT * FROM comments where post_id=?";
        $comments = $this->mapper->fetchAll($query, [$id]);
        $collection = new Collection($comments);
        $collection->handleItem(fn($item) => $this->createCommentFromArray($item));
        return $collection;
    }

    public function deferFindByPostId(int $id): CollectionInterface
    {
        $collection = new DeferCollection(function () use ($id) {
            $query = "SELECT * FROM comments where post_id=?";
            return $this->mapper->fetchAll($query, [$id]);
        });
        $collection->handleItem(fn($item) => $this->createCommentFromArray($item));
        return $collection;
    }

    public function findById(int $id): Comment
    {
        $query = "SELECT * FROM {$this->table} WHERE id=? ORDER BY id DESC LIMIT 1";
        $rawData = $this->mapper->fetch($query, [$id]);
        return $this->createCommentFromArray($rawData);
    }

    public function update(Comment $comment): void
    {
        $query = "UPDATE {$this->table} SET message=? WHERE id=?";
        $this->mapper->executeQuery([
            $comment->getMessage(),
            $comment->getId(),
        ], $query);
    }

    public function insert(Comment $domain): void
    {
        $query = "INSERT INTO {$this->table} (message, post_id) VALUES (?, ?)";
        $this->mapper->executeQuery([
            $domain->getMessage(),
            $domain->getPostId(),
        ], $query);
        $id = $this->mapper->getLastInsertId();
        $domain->setId($id);
    }

    public function createCommentFromArray(array $raw): Comment
    {
        $comment = new Comment();
        isset($raw['id']) && $comment->setId($raw['id']);
        isset($raw['message']) && $comment->setMessage($raw['message']);
        isset($raw['post_id']) && $comment->setPostId($raw['post_id']);

        return $comment;
    }
}