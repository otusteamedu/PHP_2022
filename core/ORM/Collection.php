<?php

namespace Otus\Task14\Core\ORM;

use Iterator;
use Otus\Task14\Core\ORM\Contract\CollectionInterface;
use Otus\Task14\Core\ORM\Contract\EntityContract;

class Collection implements Iterator, CollectionInterface
{
    private int $position = 0;

    public function __construct(private array $items = [])
    {
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): EntityContract
    {
        return $this->items[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }
}