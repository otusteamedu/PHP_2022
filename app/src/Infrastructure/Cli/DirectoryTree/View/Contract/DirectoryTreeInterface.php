<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\DirectoryTree\View\Contract;

use App\Domain\DirectoryTree\Node\AbstractNode;
use Symfony\Component\Console\Output\OutputInterface;

interface DirectoryTreeInterface
{
    /**
     * @param \RecursiveIterator<int,AbstractNode> $iterator
     */
    public function output(\RecursiveIterator $iterator, OutputInterface $output): void;
}
