<?php

namespace Otus\Task13\Core\ORM\Mapping;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Table
{
    public function __construct(public string $name)
    {
    }
}