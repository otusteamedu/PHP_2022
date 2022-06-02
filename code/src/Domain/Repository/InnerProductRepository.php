<?php


namespace Decole\Hw18\Domain\Repository;


use Decole\Hw18\Domain\Entity\InnerProduct;

class InnerProductRepository
{
    public function getAll(): array
    {
        return [
            new InnerProduct('Морковка', InnerProduct::CARROT, InnerProduct::GRAM, 20),
            new InnerProduct('Салат', InnerProduct::SALAD, InnerProduct::GRAM, 50),
            new InnerProduct('Лук', InnerProduct::ONION, InnerProduct::GRAM, 30),
            new InnerProduct('Перец', InnerProduct::PEPPER, InnerProduct::NUMERIC, 4),
            new InnerProduct('Сыр', InnerProduct::CHEESE, InnerProduct::NUMERIC, 3),
            new InnerProduct('Мясо', InnerProduct::MEAT, InnerProduct::GRAM, 90),
        ];
    }
}