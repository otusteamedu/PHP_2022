<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Contract;

use App\Domain\Comparator\Comparison;
use App\Domain\DirectoryTree\Node\AbstractNode;
use App\Domain\DirectoryTree\Size\Size;

interface BuilderInterface
{
    public function in(string $path): self;

    public function withDirSize(Comparison $comparison, Size $size): self;

    public function withFileSize(Comparison $comparison, Size $size): self;

    /** @return \RecursiveIterator<int,AbstractNode> */
    public function build(): \RecursiveIterator;
}
