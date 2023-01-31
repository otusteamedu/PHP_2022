<?php

declare(strict_types=1);

namespace Src\Sandwich\Application\Proxy;

use DI\Container;
use Src\Sandwich\Application\CookingProcess;
use Src\Sandwich\Domain\Contracts\BasicProduct;
use Src\Sandwich\Domain\Entities\BasicProducts\SpoiledBasicProduct;
use Src\Sandwich\DTO\SandwichParametersDTO;

final class CookingProcessProxy extends CookingProcess
{
    /**
     * @param Container $di_container
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(Container $di_container)
    {
        parent::__construct($di_container);
    }

    /**
     * @return BasicProduct
     */
    public function getResult(): BasicProduct
    {
        $product_status = $this->periodicDeteriorationOfTheProduct();

        $this->cooking_observer->notifySubscribers(event_name: $product_status);

        if ($product_status === 'Recycled') {
            return new SpoiledBasicProduct();
        }

        return $this->cooked_basic_product;
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @return string
     */
    private function periodicDeteriorationOfTheProduct(): string
    {
        $spoiled = rand(1, 10);

        if ($spoiled > 6) {
            return 'Recycled';
        }

        return 'IsReady';
    }
}
