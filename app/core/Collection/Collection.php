<?php

namespace Otus\Core\Collection;

use Generator;

class Collection implements CollectionInterface
{
    /** @var callable */
    private $handleItem = null;

    public function __construct(
        protected array $rawData
    )
    {
    }

    public function list(): Generator
    {
        if (is_callable($this->handleItem)) {
            foreach ($this->rawData as $raw) {
                yield ($this->handleItem)($raw);
            }
        } else {
            foreach ($this->rawData as $raw) {
                yield $raw;
            }
        }
    }

    public function handleItem(callable $call): self
    {
        $this->handleItem = $call;
        return $this;
    }

    public function count(): int
    {
        return count($this->rawData);
    }
}