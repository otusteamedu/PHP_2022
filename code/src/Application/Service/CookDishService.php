<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Service;

use Cookapp\Php\Application\Dto\DishDto;

/**
 * Cook service
 */
class CookDishService
{
    /**
     * @param CreateDishService $createDishService
     */
    public function __construct(private CreateDishService $createDishService)
    {
    }

    /**
     * @param DishDto $dishDto
     * @return void
     */
    public function cookDish(DishDto $dishDto): void
    {
        $dish = $this->createDishService->createDish($dishDto);
        $dish->cook();
        fwrite(STDOUT, 'Стоимость ' . $dish->getDescription() . ': ' . $dish->getPrice() . PHP_EOL);
    }
}
