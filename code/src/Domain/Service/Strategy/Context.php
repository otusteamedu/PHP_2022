<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service\Strategy;


use Decole\Hw18\Domain\Entity\Dish;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;

class Context
{
    private $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function makeFinishDish(ProductInterface $baseProduct): Dish
    {
        return $this->strategy->cook($baseProduct);
    }
}