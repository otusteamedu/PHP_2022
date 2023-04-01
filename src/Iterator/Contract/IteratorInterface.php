<?php

namespace Otus\Task14\Iterator\Contract;

interface IteratorInterface
{
    public function getNext(): mixed;
    public function hasNext(): bool;
}