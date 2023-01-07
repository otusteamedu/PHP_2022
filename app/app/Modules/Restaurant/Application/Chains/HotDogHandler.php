<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Application\Chains;

use App\Modules\Restaurant\Application\Chains\HotDogChainElements\HotDogBunElement;
use App\Modules\Restaurant\Application\Chains\HotDogChainElements\KetchupElement;
use App\Modules\Restaurant\Application\Chains\HotDogChainElements\MustardElement;
use App\Modules\Restaurant\Application\Chains\HotDogChainElements\OnionElement;
use App\Modules\Restaurant\Application\Chains\HotDogChainElements\SausageElement;
use App\Modules\Restaurant\Domain\Repositories\HotDogIngredientsRepository;
use Exception;

class HotDogHandler
{
    /**
     * @throws Exception
     */
    public static function checkIngredients(string $sauce): void
    {
        $ingredients = app(HotDogBunElement::class)
            ->setNext(app(OnionElement::class))
            ->setNext(app(SausageElement::class));

        match ($sauce) {
            'mustard' => $ingredients->setNext(app(MustardElement::class)),
            'ketchup' => $ingredients->setNext(app(KetchupElement::class)),
            default => throw new Exception('Не известный соус'),
        };

        (new Chain($ingredients))->checkIngredients(app(HotDogIngredientsRepository::class));
    }
}
