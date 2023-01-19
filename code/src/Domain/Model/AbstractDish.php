<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Model;

/**
 * Dish
 */
abstract class AbstractDish
{
    protected string $description;
    protected int $price;

    /**
     * @return string
     */
    abstract public function getDescription(): string;

    /**
     * @return int
     */
    abstract public function getPrice(): int;

    /**
     * @return void
     */
    abstract public function cook(): void;
}
