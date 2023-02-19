<?php

namespace Otus\Task13\Core\ORM\Contract;


interface CollectionInterface
{

    public function rewind(): void;

    public function current();

    public function key(): int;

    public function next(): void;

    public function valid(): bool;
}