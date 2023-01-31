<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Contracts\Events;

interface CookingEvent
{
    public function updateCookingStatus(): void;
}
