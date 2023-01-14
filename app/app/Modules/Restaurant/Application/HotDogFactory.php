<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Application;

use App\Modules\Restaurant\Application\Chains\HotDogChainElements\KetchupElement;
use App\Modules\Restaurant\Application\Chains\HotDogChainElements\MustardElement;
use App\Modules\Restaurant\Application\Chains\HotDogHandler;
use App\Modules\Restaurant\Domain\Burger;
use App\Modules\Restaurant\Domain\HotDogBuilder;
use App\Modules\Restaurant\Domain\Ingredients\HotDogBun;
use App\Modules\Restaurant\Domain\Ingredients\KetchupSauce;
use App\Modules\Restaurant\Domain\Ingredients\MustardSauce;
use App\Modules\Restaurant\Domain\Ingredients\Onion;
use App\Modules\Restaurant\Domain\Ingredients\Sausage;
use Exception;

class HotDogFactory implements BurgerFactoryInterface
{
    public function __construct(private string $sauce)
    {
    }

    /**
     * @throws Exception
     */
    public function create(): Burger
    {
        HotDogHandler::checkIngredients($this->sauce);
        $hotDogBuilder = new HotDogBuilder();
        $hotDogBuilder
            ->setBun(app(HotDogBun::class))
            ->setOnion(app(Onion::class))
            ->setSausage(app(Sausage::class));

        match ($this->sauce) {
            'mustard' => $hotDogBuilder->setSauce(app(MustardSauce::class)),
            'ketchup' => $hotDogBuilder->setSauce(app(KetchupSauce::class))
        };
        return $hotDogBuilder->make();
    }
}
