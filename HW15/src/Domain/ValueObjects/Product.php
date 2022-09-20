<?php
declare(strict_types=1);

namespace App\Domain\ValueObjects;

class Product
{
    protected int $id;
    protected string $name;
    protected float $price;

    /**
     * @param int $id
     * @param string $name
     * @param float $price
     */
    public function __construct(int $id, string $name, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice() : float
    {
        return $this->price;
    }




}