<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Status;

class Status
{
    private StatusEnum $value;

    /**
     * @param StatusEnum $value
     */
    public function __construct(StatusEnum $value)
    {
    }

    /**
     * @return StatusEnum
     */
    public function getValue(): StatusEnum
    {
        return $this->value;
    }

    /**
     * @param StatusEnum $value
     * @return Status
     */
    public function setValue(StatusEnum $value): self
    {
        $this->value = $value;
        return $this;
    }
}