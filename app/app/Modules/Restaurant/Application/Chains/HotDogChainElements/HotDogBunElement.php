<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Application\Chains\HotDogChainElements;

use App\Modules\Restaurant\Application\Chains\BurgerElement;
use App\Modules\Restaurant\Domain\Repositories\IngredientsRepositoryInterface;
use Exception;

class HotDogBunElement extends BurgerElement
{
    /**
     * @throws Exception
     */
    public function handle(IngredientsRepositoryInterface $repository): void
    {
        if (!$repository::getBun()) {
            throw new Exception('Закончились булочки для хот-дога');
        }
        parent::handle($repository);
    }
}
