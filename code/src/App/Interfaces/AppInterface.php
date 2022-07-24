<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\App\Interfaces;

interface AppInterface
{
    /**
     * @return string
     */
    public function handle(): string;
}