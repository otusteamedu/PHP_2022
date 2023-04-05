<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\Contract;

use App\Domain\DirectoryTree\Node\AbstractNode;

/**
 * @template T of AbstractNode
 * @extends PresentationInterface<T>
 */
interface PresentationTagInterface extends PresentationInterface
{
    public static function tag(): string;
}
