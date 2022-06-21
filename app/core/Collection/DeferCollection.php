<?php

namespace Otus\Core\Collection;

use Generator;

class DeferCollection implements CollectionInterface
{
    /** @var callable */
    protected $callData;
    /** @var callable */
    private $handleItem = null;
    protected array $rawData = [];

    public function __construct(
        callable $call
    )
    {
        $this->callData = $call;
    }

    public function list(): Generator
    {
        $this->setRawData(($this->callData)());

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

    private function setRawData(array $data): void
    {
        $this->rawData = $data;
    }
}