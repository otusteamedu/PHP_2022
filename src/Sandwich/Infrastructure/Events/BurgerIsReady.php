<?php

declare(strict_types=1);

namespace Src\Sandwich\Infrastructure\Events;

use Src\Sandwich\Domain\Contracts\Events\CookingEvent;

final class BurgerIsReady implements CookingEvent
{
    /**
     * @return void
     */
    public function updateCookingStatus(): void
    {
        echo 'Burger is ready' . PHP_EOL;
    }
}
