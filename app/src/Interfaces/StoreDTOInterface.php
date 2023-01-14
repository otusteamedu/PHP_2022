<?php

declare(strict_types=1);

namespace HW10\App\Interfaces;

interface StoreDTOInterface
{
    public function getName(): string;

    public function getStore(): int;
}
