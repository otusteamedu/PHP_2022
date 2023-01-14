<?php

declare(strict_types=1);

namespace Otus\App\Viewer;

/**
 * Output interface
 */
interface OutputInterface
{
    public function echo(array $books): void;
}
