<?php


namespace Decole\Hw18\Domain\Service\Iterator;


class InnerProductValidateIterator implements \Iterator
{
    private int $position = 0;

    public function __construct(private array $collection, private bool $reverse = false)
    {
    }

    public function current(): mixed
    {
        return $this->collection[$this->position];
    }

    public function next(): void
    {
        $this->position = $this->position + ($this->reverse ? -1 : 1);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = $this->reverse ?
            count($this->collection) - 1 : 0;
    }
}