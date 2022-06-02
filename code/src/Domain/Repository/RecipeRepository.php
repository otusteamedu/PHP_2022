<?php


namespace Decole\Hw18\Domain\Repository;


use Decole\Hw18\Domain\Entity\InnerProduct;
use Decole\Hw18\Domain\Entity\Recipe;

class RecipeRepository
{
    public function getAll(): array
    {
        return [
            new Recipe('Морковный фарш', [
                new InnerProduct('Моркова', InnerProduct::CARROT, InnerProduct::GRAM, 90),
                new InnerProduct('Мясо утиное', InnerProduct::MEAT, InnerProduct::GRAM, 180),
                new InnerProduct('Лук', InnerProduct::ONION, InnerProduct::GRAM, 30),
            ]),
            new Recipe('Стандарт', [
                new InnerProduct('Мясо', InnerProduct::MEAT, InnerProduct::GRAM, 180),
                new InnerProduct('Сыр', InnerProduct::CHEESE, InnerProduct::GRAM, 60),
                new InnerProduct('Лук', InnerProduct::ONION, InnerProduct::GRAM, 30),
            ]),
            new Recipe('Для веганов и вегетырианцев', [
                new InnerProduct('Морковка', InnerProduct::CARROT, InnerProduct::GRAM, 30),
                new InnerProduct('Салат', InnerProduct::SALAD, InnerProduct::GRAM, 90),
                new InnerProduct('Лук', InnerProduct::ONION, InnerProduct::GRAM, 30),
                new InnerProduct('Перец', InnerProduct::PEPPER, InnerProduct::GRAM, 40),
                new InnerProduct('Сыр', InnerProduct::CHEESE, InnerProduct::GRAM, 30),
            ]),
        ];
    }

    public function getByName(string $name): ?Recipe
    {
        $all = $this->getAll();

        foreach ($all as $recipe) {
            if ($recipe->name === $name) {
                return $recipe;
            }
        }

        return null;
    }
}