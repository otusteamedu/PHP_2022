<?php

use App\Application\Component\DataMapper\IdentityMap;
use App\Application\Component\Event\EventDispatcher;
use App\Application\Component\Event\ListenerProvider;
use App\Application\Component\Http\Request;
use App\Application\EventListener\CreditRequestListener;
use App\Domain\Event\CreditRequested;

return [
    'request' => DI\create(Request::class)->constructor($_GET, $_POST),

    'listenerProvider' => DI\create(ListenerProvider::class)->method(
        'addListener',
        CreditRequested::class,
        new CreditRequestListener()
    ),

    'dispatcher' => DI\create(EventDispatcher::class)->constructor(DI\get('listenerProvider')),

    'identityMap' => DI\create(IdentityMap::class),
];