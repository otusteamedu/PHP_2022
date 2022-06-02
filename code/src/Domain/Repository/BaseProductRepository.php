<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Repository;


use Decole\Hw18\Domain\Entity\BaseProduct;

class BaseProductRepository
{
    public function getAll(): array
    {
        return [
            new BaseProduct('Бургер', BaseProduct::BURGER),
            new BaseProduct('Сэндвитч', BaseProduct::SANDWICH),
            new BaseProduct('Хотдог', BaseProduct::HOTDOG),
        ];
    }
}