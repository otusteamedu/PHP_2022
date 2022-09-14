<?php

namespace Mselyatin\Patterns\infrastructure\mappers;

use Mselyatin\Patterns\application\decorators\bakery\BeefBakeryDecorator;
use Mselyatin\Patterns\application\decorators\bakery\BunBakeryDecorator;
use Mselyatin\Patterns\application\decorators\bakery\KetchupBakeryDecorator;
use Mselyatin\Patterns\application\decorators\bakery\MayonnaiseDecorator;
use Mselyatin\Patterns\application\decorators\bakery\OnionBakeryDecorator;
use Mselyatin\Patterns\application\decorators\bakery\PorkBakeryDecorator;
use Mselyatin\Patterns\application\decorators\bakery\SausageBakeryDecorator;
use Mselyatin\Patterns\application\interfaces\strategies\FastFoodCreatingStrategyInterface;
use Mselyatin\Patterns\application\strategies\creating\BurgerFastFoodCreatingStrategy;
use Mselyatin\Patterns\application\strategies\creating\HotDogFastFoodCreatingStrategy;
use Mselyatin\Patterns\application\strategies\creating\SandwichFastFoodCreatingStrategy;
use Mselyatin\Patterns\domain\constants\BakeryTypesConstants;
use Mselyatin\Patterns\domain\valueObjects\bakery\BeefValueObject;
use Mselyatin\Patterns\domain\valueObjects\bakery\BunValueObject;
use Mselyatin\Patterns\domain\valueObjects\bakery\OnionValueObject;
use Mselyatin\Patterns\domain\valueObjects\bakery\PorkValueObject;
use Mselyatin\Patterns\domain\valueObjects\bakery\SausageValueObject;
use Mselyatin\Patterns\domain\valueObjects\sauces\KetchupValueObject;
use Mselyatin\Patterns\domain\valueObjects\sauces\MayonnaiseValueObject;

class StringIdToCompositionMapper
{
    protected const MAP = [
        'beef' => BeefBakeryDecorator::class,
        'bun' => BunBakeryDecorator::class,
        'onion' => OnionBakeryDecorator::class,
        'pork' => PorkBakeryDecorator::class,
        'sausage' => SausageBakeryDecorator::class,
        'mayonnaise' => MayonnaiseDecorator::class,
        'ketchup' => KetchupBakeryDecorator::class
    ];

    /**
     * @param string $type
     * @return ?string
     */
    public static function map(string $type): ?string
    {
        return self::MAP[$type] ?? null;
    }
}