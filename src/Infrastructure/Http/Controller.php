<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http;

use DKozlov\Otus\Application\Builder\Interface\ProductBuilderInterface;
use DKozlov\Otus\Application\Observer\Interface\ProductObserverInterface;
use DKozlov\Otus\Application\Observer\ProductSubscriber;
use DKozlov\Otus\Domain\Model\Exception\ProductIngredientsNotFoundException;

class Controller
{
    public function index(
        ProductBuilderInterface $builder,
        ProductObserverInterface $observer
    ): void {
        $observer->subscribe(new ProductSubscriber());

        try {
            $item = $builder->cookByReceipt();

            echo 'Собран: ' . $item->who() . '<br>';
            echo 'Который состоит из: ' . '<br>';

            foreach ($item->getIngredients() as $ingredient) {
                echo $ingredient->name() . '<br>';
            }
        } catch (ProductIngredientsNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}