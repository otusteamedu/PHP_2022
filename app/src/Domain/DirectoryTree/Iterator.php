<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree;

use App\Domain\DirectoryTree\Node\Directory;
use App\Domain\DirectoryTree\Node\File;
use App\Exceptions\UnexpectedValueException;

/**
 * @implements \RecursiveIterator<int,File|Directory>
 */
final class Iterator implements \RecursiveIterator
{
    private int $position;

    /** @var array<int, File|Directory> */
    private readonly array $nodes;

    public function __construct(Directory $node)
    {
        $this->nodes = $node->getChildren();
    }

    /** {@inheritdoc} */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /** {@inheritdoc} */
    public function valid(): bool
    {
        return $this->position < \count($this->nodes);
    }

    /** {@inheritdoc} */
    public function key(): int
    {
        return $this->position;
    }

    /** {@inheritdoc} */
    public function current(): mixed
    {
        return $this->nodes[$this->position];
    }

    /** {@inheritdoc} */
    public function next(): void
    {
        ++$this->position;
    }

    /** {@inheritdoc} */
    public function getChildren(): self
    {
        if ($this->valid() && $this->nodes[$this->position] instanceof Directory) {
            return new self($this->nodes[$this->position]);
        }

        throw new UnexpectedValueException(sprintf('expected %s class', Directory::class));
    }

    /** {@inheritdoc} */
    public function hasChildren(): bool
    {
        return $this->nodes[$this->position] instanceof Directory;
    }
}
