<?php

namespace Otus\Task14\Core\ORM\Mapping;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Entity
{
    public function __construct(public string $transform)
    {
    }
}