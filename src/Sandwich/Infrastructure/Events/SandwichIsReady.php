<?php

declare(strict_types=1);

namespace Src\Sandwich\Infrastructure\Events;

use Src\Sandwich\Domain\Contracts\Events\CookingEvent;

final class SandwichIsReady implements CookingEvent
{
    /**
     * @return void
     */
    public function updateCookingStatus(): void
    {
        echo 'Sandwich is ready' . PHP_EOL;
    }
}
