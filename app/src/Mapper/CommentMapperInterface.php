<?php

namespace Otus\App\Mapper;

use Otus\App\Model\Comment;
use Otus\Core\Collection\CollectionInterface;

interface CommentMapperInterface
{
    const TABLE_NAME = 'comments';

    public function fetchAll(): CollectionInterface;

    public function findByPostId(int $id): CollectionInterface;

    public function deferFindByPostId(int $id): CollectionInterface;

    public function findById(int $id): ?Comment;

    public function update(Comment $comment): void;

    public function insert(Comment $domain): void;

    public function createCommentFromArray(array $raw): Comment;
}