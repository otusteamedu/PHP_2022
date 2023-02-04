<?php

namespace Otus\Task12\Core\ORM\Mapping;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PrimaryKey
{
    public function __construct(public readonly string $primaryKey){}

}