<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain\Repositories;


class HotDogIngredientsRepository implements IngredientsRepositoryInterface
{
    public static function getBun(): int
    {
        return rand(0, 1);
    }

    public static function getSausage(): int
    {
        return rand(0, 1);
    }

    public static function getOnion(): int
    {
        return rand(0, 1);
    }

    public static function getKetchup(): int
    {
        return rand(0, 1);
    }

    public static function getMustard(): int
    {
        return rand(0, 1);
    }

}
