<?php
declare(strict_types=1);

namespace Domain\ValueObjects;

class Stock
{
    protected string $title;
    protected int $quantity;

    /**
     * @param string $title
     * @param int $quantity
     */
    public function __construct(string $title, int $quantity)
    {
        $this->title = $title;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }



}