<?php

namespace Nsavelev\Hw6\App\Interfaces;

interface CommandInterface
{
    /**
     * @return void
     */
    public function handle(): void;
}