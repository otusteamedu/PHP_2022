<?php

namespace Anosovm\HW5\Dtos;

class AbstractDto
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}