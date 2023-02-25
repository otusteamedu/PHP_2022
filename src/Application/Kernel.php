<?php

declare(strict_types=1);

namespace Src\Application;

final class Kernel
{
    /**
     * @return void
     * @throws \Exception
     */
    public function runApplication(): void
    {
        \app()->create();
    }
}
