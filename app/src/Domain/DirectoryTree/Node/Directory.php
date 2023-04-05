<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Node;

use App\Domain\DirectoryTree\Directory\Content;
use App\Domain\DirectoryTree\File\Factory;
use App\Domain\DirectoryTree\Size\Size;

final class Directory extends AbstractNode
{
    /** @var array<int, Directory|File> */
    private array $children = [];

    public function __construct(string $path, int $depth = 0)
    {
        parent::__construct(pathinfo($path, \PATHINFO_BASENAME), $path, new Size(), $depth);

        ++$depth;
        foreach (Content::list($this->getPath()) as $child) {
            $child = $this->addChildren($child, $depth);
            $this->getSize()->add($child->getSize());
        }
    }

    public function addChildren(string $path, int $depth): AbstractNode
    {
        $child = is_file($path) ? Factory::default()->create($path, $depth) : new self($path, $depth);
        $this->children[] = $child;

        return $child;
    }

    /** @return array<int, Directory|File> */
    public function getChildren(): array
    {
        return $this->children;
    }
}
