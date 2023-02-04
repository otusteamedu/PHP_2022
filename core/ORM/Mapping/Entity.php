<?php

namespace Otus\Task12\Core\ORM\Mapping;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Entity
{
    public function __construct(public string $transform){}
}