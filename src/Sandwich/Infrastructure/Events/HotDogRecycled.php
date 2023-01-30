<?php

declare(strict_types=1);

namespace Src\Sandwich\Infrastructure\Events;

use Src\Sandwich\Domain\Contracts\Events\CookingEvent;

final class HotDogRecycled implements CookingEvent
{
    /**
     * @return void
     */
    public function updateCookingStatus(): void
    {
        echo 'HotDog spoiled' . PHP_EOL;
    }
}
