<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\EventListener;

use Nikolai\Php\Infrastructure\Event\PostCookEvent;

class PostCookEventListener
{
    public function __invoke(PostCookEvent $event): void
    {
        fwrite(STDOUT, 'PostCookEventListener!' . get_class($this) . PHP_EOL);
//        var_dump($event);
//        $object = $event->getObject();

    }
}