<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Contracts;

interface BasicProduct
{
    /**
     * @return $this
     */
    public function cook(): self;
}
