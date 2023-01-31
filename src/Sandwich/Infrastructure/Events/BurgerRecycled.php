<?php

declare(strict_types=1);

namespace Src\Sandwich\Infrastructure\Events;

use Src\Sandwich\Domain\Contracts\Events\CookingEvent;

final class BurgerRecycled implements CookingEvent
{
    /**
     * @return void
     */
    public function updateCookingStatus(): void
    {
        echo 'Бургер испорчен и был утилизирован' . PHP_EOL;
    }
}
