<?php

namespace Otus\Task13\Product\Application\Dto\Response;

class CreateProductResponseDto
{
    public function __construct(
        public string  $id,
        public string  $name,
        public ?string $description = null)
    {
    }
}