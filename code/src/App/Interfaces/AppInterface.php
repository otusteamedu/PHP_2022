<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\App\Interfaces;

interface AppInterface
{
    /**
     * @param $argc
     * @param $argv
     * @return string
     */
    public function handle($argc, $argv): string;
}