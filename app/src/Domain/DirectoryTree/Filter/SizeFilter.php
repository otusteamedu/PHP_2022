<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Filter;

use App\Domain\Comparator\Contract\CompareInterface;
use App\Domain\DirectoryTree\Node\AbstractNode;
use RecursiveIterator;

/**
 * @extends \RecursiveFilterIterator<int,AbstractNode, \RecursiveIterator<int,AbstractNode>>
 */
final class SizeFilter extends \RecursiveFilterIterator
{
    /** @var CompareInterface[] */
    private array $comparators;

    /**
     * @param \RecursiveIterator<int,AbstractNode> $iterator
     * @param CompareInterface                     ...$comparators
     */
    public function __construct(RecursiveIterator $iterator, CompareInterface ...$comparators)
    {
        $this->comparators = $comparators;

        parent::__construct($iterator);
    }

    public function accept(): bool
    {
        /** @var AbstractNode $node */
        $node = $this->current();

        foreach ($this->comparators as $comparator) {
            if (!$comparator->isSupported($node)) {
                continue;
            }
            if (!$comparator->compare($node)) {
                return false;
            }
        }

        return true;
    }
}
