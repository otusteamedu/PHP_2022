<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\Contract;

use App\Domain\DirectoryTree\Node\AbstractNode;

/**
 * @template T of AbstractNode
 */
interface PresentationInterface
{
    /**
     * @param T $element
     */
    public function present(mixed $element): string;
}
