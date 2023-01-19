<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\Dispatcher;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * AbstractEvent
 */
abstract class AbstractEvent implements StoppableEventInterface
{
    /**
     * @var bool
     */
    private bool $propagationStopped = false;

    /**
     * @return bool
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     * @return void
     */
    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
