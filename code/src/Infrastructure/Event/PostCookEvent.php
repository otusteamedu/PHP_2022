<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\Event;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Infrastructure\Dispatcher\AbstractEvent;

/**
 * After cook event
 */
class PostCookEvent extends AbstractEvent
{
    /**
     * @param AbstractDish $dish
     */
    public function __construct(private AbstractDish $dish)
    {
    }
}
