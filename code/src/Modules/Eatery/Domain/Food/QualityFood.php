<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Food;

use Nikcrazy37\Hw14\Libs\Config;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Exception\QualityFoodException;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\DTO\Ingredients;
use DI\Container;

class QualityFood extends AbstractFood
{
    private FoodFactory $food;
    private Container $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
//        $food = $this->getFood();
        $food = $this->container->get(BurgerFood::class);
        parent::__construct($container);
    }

    public function getFood()
    {
        return $this->food;
    }

    public function setFood($foodName)
    {
        $this->food = $this->container->get($foodName);
    }

    /**
     * @return array
     * @throws QualityFoodException
     */
    public function createRecipe(): array
    {
        $recipe = $this->food->createRecipe();

        if (!$this->checkQuality($recipe)) {
            throw new QualityFoodException($this->getFoodName());
        }

        return $recipe;
    }

    public function addIngredients(?Ingredients $ingredients)
    {
        parent::addIngredients($ingredients);
    }

    /**
     * @param array $recipe
     * @return bool
     */
    private function checkQuality(array $recipe): bool
    {
        $standardRecipe = Config::getOption($this->getFoodUpperName() . "_RECIPE");

        $intersect = array_values(
            array_unique(
                array_intersect($recipe, $standardRecipe)
            )
        );

        return $standardRecipe === $intersect;
    }

    /**
     * @return string
     */
    private function getFoodName(): string
    {
        $reflect = new \ReflectionClass($this->food);

        return str_replace("Food", "", $reflect->getShortName());
    }

    /**
     * @return string
     */
    private function getFoodUpperName(): string
    {
        return strtoupper($this->getFoodName());
    }
}