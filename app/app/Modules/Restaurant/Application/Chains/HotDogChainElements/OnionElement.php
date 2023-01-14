<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Application\Chains\HotDogChainElements;

use App\Modules\Restaurant\Application\Chains\BurgerElement;
use App\Modules\Restaurant\Domain\Burger;
use App\Modules\Restaurant\Domain\Ingredients\Onion;
use App\Modules\Restaurant\Domain\Ingredients\Sausage;
use App\Modules\Restaurant\Domain\Repositories\HotDogIngredientsRepository;
use App\Modules\Restaurant\Domain\Repositories\IngredientsRepositoryInterface;
use Exception;

class OnionElement extends BurgerElement
{
    /**
     * @throws Exception
     */
    public function handle(IngredientsRepositoryInterface $repository): void
    {
        if (!$repository::getOnion()) {
            throw new Exception('Закончился лук');
        }
        parent::handle($repository);
    }
}
