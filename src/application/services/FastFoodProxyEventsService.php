<?php

namespace Mselyatin\Patterns\application\services;

use Mselyatin\Patterns\Application;
use Mselyatin\Patterns\application\interfaces\services\FastFoodServiceInterface;
use Mselyatin\Patterns\application\interfaces\strategies\FastFoodCreatingStrategyInterface;
use Mselyatin\Patterns\domain\collections\valueObjects\CompositionBakeryCollection;
use Mselyatin\Patterns\domain\events\EventDispatch;
use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\events\EventDispatchInterface;
use Mselyatin\Patterns\domain\interfaces\events\EventExistsInterface;
use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class FastFoodProxyEventsService implements FastFoodServiceInterface, EventExistsInterface
{
    /**
     * @var FastFoodServiceInterface
     */
    private FastFoodServiceInterface $fastFoodService;

    /**
     * @var EventDispatchInterface
     */
    private EventDispatchInterface $eventDispatch;

    /**
     * @param FastFoodCreatingStrategyInterface $fastFoodCreatingStrategy
     */
    public function __construct(
        FastFoodCreatingStrategyInterface $fastFoodCreatingStrategy
    ) {
        $this->fastFoodService = new FastFoodService($fastFoodCreatingStrategy);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function createFood(
        ReadinessStatusValue $readinessStatusValue,
        CollectionInterface $compositionBakeryCollection = new CompositionBakeryCollection()
    ): BakeryInterface {
        $this->eventDispatch = new EventDispatch($readinessStatusValue, $compositionBakeryCollection);
        $this->setEvents();

        $this->eventDispatch->dispatchBeforeEvents();
        $food = $this->fastFoodService->createFood($readinessStatusValue, $compositionBakeryCollection);
        $this->eventDispatch->dispatchAfterEvents();

        return $food;
    }

    /**
     * @todo Такое решение не нравится, но другое не придумал, слишком сложная архитектура
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function setEvents(): void
    {
        $events = Application::$container->get('eventForFastFoodServiceProxy');
        $eventsAfter = $events['after'] ?? [];
        $eventsBefore = $events['before'] ?? [];

        array_walk($eventsAfter, function ($event) {
            $this->eventDispatch->addAfterEvent($event);
        });

        array_walk($eventsBefore, function ($event) {
            $this->eventDispatch->addBeforeEvent($event);
        });
    }

}