<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Proxy;

use Cookapp\Php\Domain\Model\CookableInterface;
use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Infrastructure\Event\PostCookEvent;
use Cookapp\Php\Infrastructure\Event\PreCookEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Proxy
 */
class CookProxy implements CookableInterface
{
    /**
     * @param CookableInterface $cookingStrategy
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(private CookableInterface $cookingStrategy, private EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * @return void
     */
    public function cook(): void
    {
        fwrite(STDOUT, 'Прокси: Начинаем готовить ' . $this->getDish()->getDescription() . PHP_EOL);

        $preCookEvent = new PreCookEvent($this->cookingStrategy->getDish());
        $this->eventDispatcher->dispatch($preCookEvent);

        $this->cookingStrategy->cook();

        $postCookEvent = new PostCookEvent($this->cookingStrategy->getDish());
        $this->eventDispatcher->dispatch($postCookEvent);
    }

    /**
     * @return AbstractDish
     */
    public function getDish(): AbstractDish
    {
        return $this->cookingStrategy->getDish();
    }
}
