<?php

namespace Otus\Core\Collection;

use Generator;

interface CollectionInterface
{
    public function count(): int;

    public function list(): Generator;

    public function handleItem(callable $call): self;
}