<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Proxy;

use Nikolai\Php\Domain\Model\CookableInterface;

class CookProxy implements CookableInterface
{
    public function __construct(private CookableInterface $cook) {}

    public function cook(): void
    {

        $this->cook->cook();

    }
}