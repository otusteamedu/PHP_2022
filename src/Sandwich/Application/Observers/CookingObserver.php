<?php

declare(strict_types=1);

namespace Src\Sandwich\Application\Observers;

use DI\Container;
use Src\Sandwich\Domain\Contracts\BasicProduct;
use Src\Sandwich\Domain\Contracts\Events\CookingTraceability;

final class CookingObserver implements CookingTraceability
{
    /**
     * @var array
     */
    private array $basic_products;

    /**
     * @var Container
     */
    private Container $di_container;

    /**
     * @param Container $di_container
     */
    public function __construct(Container $di_container)
    {
        $this->di_container = $di_container;
    }

    /**
     * @param BasicProduct $basic_product
     * @return void
     */
    public function subscribe(BasicProduct $basic_product): void
    {
        $this->basic_products[(string) $basic_product] = 'subscribed';
    }

    /**
     * @param BasicProduct $basic_product
     * @return void
     */
    public function unsubscribe(BasicProduct $basic_product): void
    {
        unset($this->basic_products[(string) $basic_product]);
    }

    /**
     * @param string $event_name
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function notifySubscribers(string $event_name): void
    {
        foreach ($this->basic_products as $basic_product => $data) {
            $event = $this->di_container->make(name: $basic_product . $event_name);

            $event->updateCookingStatus();
        }
    }
}
