<?php

declare(strict_types=1);

namespace Otus\App\Viewer;

interface OutputInterface
{
    public function echo(array $books): void;
}
