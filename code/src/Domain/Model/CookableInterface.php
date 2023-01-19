<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Model;

/**
 * Cookable interface
 */
interface CookableInterface
{
    /**
     * @return void
     */
    public function cook(): void;

    /**
     * @return AbstractDish
     */
    public function getDish(): AbstractDish;
}
