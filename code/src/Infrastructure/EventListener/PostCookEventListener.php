<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\EventListener;

use Cookapp\Php\Infrastructure\Event\PostCookEvent;

class PostCookEventListener
{
    public function __invoke(PostCookEvent $event): void
    {
        fwrite(STDOUT, 'PostCookEventListener, event: PostCookEvent' . PHP_EOL . PHP_EOL);
    }
}