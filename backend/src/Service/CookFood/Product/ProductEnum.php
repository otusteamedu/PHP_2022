<?php

namespace App\Service\CookFood\Product;

enum ProductEnum: string
{
    case Burger = "burger";
    case HotDog = "hotDog";
    case Sandwich = "sandwich";

    public static function getValues(): array
    {
        return array_map(fn(ProductEnum $i) => $i->value, self::cases());
    }
}