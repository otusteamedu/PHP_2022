<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Event;

use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Infrastructure\Dispatcher\AbstractEvent;

class PreCookEvent extends AbstractEvent
{
    public function __construct(private AbstractDish $dish) {}
}