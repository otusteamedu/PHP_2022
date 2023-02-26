<?php

namespace Otus\Task13\Core\ORM\Mapping;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{
    public function __construct(public readonly string $name)
    {
    }

}