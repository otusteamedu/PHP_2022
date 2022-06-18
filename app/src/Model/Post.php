<?php

namespace Otus\App\Model;

use Otus\Core\Collection\Collection;
use Otus\Core\Database\DomainObject;
use Otus\Core\Collection\CollectionInterface;

class Post extends DomainObject
{
    private int $id;
    private string $title;
    private CollectionInterface $comments;
    public function __construct()
    {
        $this->comments = new Collection([]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getComments(): CollectionInterface
    {
        return $this->comments;
    }

    public function setComments(CollectionInterface $comments): void
    {
        $this->comments = $comments;
    }
}