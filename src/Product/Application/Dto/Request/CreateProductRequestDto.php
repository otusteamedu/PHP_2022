<?php

namespace Otus\Task13\Product\Application\Dto\Request;
class CreateProductRequestDto
{
    public function __construct(public $name, public $description)
    {
    }
}