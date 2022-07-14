<?php

namespace Mselyatin\Project15\src\datamapper\identity;

use Mselyatin\Project15\src\common\interfaces\IdentityInterface;
use Mselyatin\Project15\src\common\valueObjects\CarBrand;
use Mselyatin\Project15\src\common\valueObjects\CarName;
use Mselyatin\Project15\src\common\valueObjects\ColorHex;
use Mselyatin\Project15\src\common\valueObjects\PriceFloat;

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
     * @param CarName $name
     * @param CarBrand $brand
     * @param ColorHex $color
     * @param PriceFloat $price
     */
    public function __construct(
        CarName $name,
        CarBrand $brand,
        ColorHex $color,
        PriceFloat $price
    ) {
        $this->name = $name->getValue();
        $this->brand = $brand->getValue();
        $this->color = $color->getValue();
        $this->price = $price->getValue();
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
     * @throws \Assert\AssertionFailedException
     */
    public static function createFromState(array $fields): self
    {
        return new self(
            CarName::create($fields['name']),
            CarBrand::create($fields['brand']),
            ColorHex::create($fields['color']),
            PriceFloat::create($fields['price'])
        );
    }
}