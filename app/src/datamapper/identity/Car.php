<?php

namespace Mselyatin\Project15\src\datamapper\identity;

use Mselyatin\Project15\src\datamapper\interfaces\IdentityInterface;

/**
 * Class Car
 * @package Mselyatin\Project6\src\datamapper\identity
 */
class Car implements IdentityInterface
{
    /**
     * Название автомобиля
     * @var string
     */
    private string $name;

    /**
     * Марка автомобиля
     * @var string
     */
    private string $brand;

    /**
     * Цвет автомобиля
     * @var string
     */
    private string $color;

    /**
     * Цена автомобиля
     * @var float
     */
    private float $price;

    /**
     * Car constructor.
     * @param string $name
     * @param string $brand
     * @param string $color
     * @param float $price
     */
    public function __construct(
      string $name,
      string $brand,
      string $color,
      float $price
    ) {
        $this->name = $name;
        $this->brand = $brand;
        $this->color = $color;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param array $fields
     * @return static
     */
    public static function createFromState(array $fields): self
    {
        return new self(
            (string)$fields['name'],
            (string)$fields['brand'],
            (string)$fields['color'],
            (float)$fields['price']
        );
    }
}