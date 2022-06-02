<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Entity;


class DishWrapper
{
    public function __construct(public string $type)
    {
    }
}