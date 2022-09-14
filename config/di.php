<?php

use Psr\Container\ContainerInterface;
use Mselyatin\Patterns\application\observer\subscribers\SimpleEchoSubscribeReadinessStatus;
use Mselyatin\Patterns\application\collections\observer\ObserverSubscriberCollection;
use Mselyatin\Patterns\application\strategies\creating\BurgerFastFoodCreatingStrategy;
use Mselyatin\Patterns\application\strategies\creating\HotDogFastFoodCreatingStrategy;
use Mselyatin\Patterns\application\strategies\creating\SandwichFastFoodCreatingStrategy;
use Mselyatin\Patterns\application\factories\bakery\BurgerFastFoodFactory;
use Mselyatin\Patterns\application\factories\bakery\HotDogFastFoodFactory;
use Mselyatin\Patterns\application\factories\bakery\SandwichFastFoodFactory;
use Mselyatin\Patterns\application\interfaces\services\FastFoodServiceInterface;
use Mselyatin\Patterns\application\services\FastFoodProxyEventsService;
use Mselyatin\Patterns\application\events\FastFoodProxyAfterEvent;
use Mselyatin\Patterns\application\events\FastFoodProxyBeforeEvent;

return [
    'bakeryListeners' => DI\factory(function (ContainerInterface $container) {
        return (new ObserverSubscriberCollection())
            ->add(new SimpleEchoSubscribeReadinessStatus());
    }),
    'eventForFastFoodServiceProxy' => DI\factory(function (ContainerInterface $container) {
        return [
            'after' => [
                new FastFoodProxyAfterEvent()
            ],
            'before' => [
                new FastFoodProxyBeforeEvent()
            ]
        ];
    }),
    FastFoodServiceInterface::class => function () {
        return FastFoodProxyEventsService::class;
    },
    BurgerFastFoodCreatingStrategy::class => DI\autowire()
        ->constructor(new BurgerFastFoodFactory()),
    HotDogFastFoodCreatingStrategy::class => DI\autowire()
        ->constructor(new HotDogFastFoodFactory()),
    SandwichFastFoodCreatingStrategy::class => DI\autowire()
        ->constructor(new SandwichFastFoodFactory()),
];