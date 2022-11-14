<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Service;

use Nikolai\Php\Application\Dto\DishDto;

class CookDishService
{
    public function __construct(private CreateDishService $createDishService) {}

    public function cookDish(DishDto $dishDto): void
    {
        $dish = $this->createDishService->createDish($dishDto);
        $dish->cook();
        fwrite(STDOUT, 'Стоимость ' . $dish->getDescription() . ': ' . $dish->getPrice() . PHP_EOL);
    }
}