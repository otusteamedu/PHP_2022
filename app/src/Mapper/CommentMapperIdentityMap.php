<?php

namespace Otus\App\Mapper;

use Otus\App\Model\Comment;
use Otus\Core\Collection\CollectionInterface;
use Otus\Core\Database\DomainWatcher;
use Otus\Core\Database\Exception\DomainWatchException;

class CommentMapperIdentityMap implements CommentMapperInterface
{
    public string $table;

    public function __construct(
        private readonly CommentMapperInterface $mapper
    )
    {
    }

    public function fetchAll(): CollectionInterface
    {
        return $this->mapper->fetchAll();
    }

    public function findByPostId(int $id): CollectionInterface
    {
        return $this->mapper->findByPostId($id);
    }

    public function deferFindByPostId(int $id): CollectionInterface
    {
        return $this->mapper->deferFindByPostId($id);
    }

    public function findById(int $id): Comment
    {
        try {
            return DomainWatcher::getByClassAndId(Comment::class, $id);
        } catch (DomainWatchException) {
            return $this->mapper->findById($id);
        }
    }

    public function update(Comment $comment): void
    {
        $this->mapper->update($comment);
    }

    public function insert(Comment $comment): void
    {
        $this->mapper->insert($comment);
        DomainWatcher::add($comment);
    }

    public function createCommentFromArray(array $raw): Comment
    {
        $comment = DomainWatcher::getByClassAndId(Comment::class, $raw['id']);
        if ($comment instanceof Comment) {
            return $comment;
        }
        $comment = $this->mapper->createCommentFromArray($raw);
        DomainWatcher::add($comment);
        return $comment;
    }
}