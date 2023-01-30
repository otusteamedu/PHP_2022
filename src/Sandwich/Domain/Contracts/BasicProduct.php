<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Contracts;

interface BasicProduct
{
    /**
     * @return array
     */
    public function cook(): array;
}
