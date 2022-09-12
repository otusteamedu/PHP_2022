<?php

use App\Application\Component\DataMapper\IdentityMap;
use App\Application\Component\Event\EventDispatcher;
use App\Application\Component\Event\ListenerProvider;
use App\Application\Component\Http\Request;
use App\Application\EventListener\CreditRequestListener;
use App\Domain\Event\CreditRequested;
use PhpAmqpLib\Connection\AMQPStreamConnection;

return [
    'request' => DI\create(Request::class)->constructor($_GET, $_POST),

    'listenerProvider' => DI\create(ListenerProvider::class)->method(
        'addListener',
        CreditRequested::class,
        new CreditRequestListener()
    ),

    'dispatcher' => DI\create(EventDispatcher::class)->constructor(DI\get('listenerProvider')),

    'identityMap' => DI\create(IdentityMap::class),

    'amqp' => DI\create(AMQPStreamConnection::class)
        ->constructor(getenv("AMQP_HOST"), getenv("AMQP_PORT"), getenv("AMQP_USER"), getenv("AMQP_PASS")),
];