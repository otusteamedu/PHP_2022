<?php

declare(strict_types=1);

namespace Philip\Otus\Core;

use Philip\Otus\Core\View\Greeting;

class Dispatcher
{
    const VIEW_GREETING = 'greeting';

    public function dispatch(string $key)
    {
        if($key === self::VIEW_GREETING) {
            return (new Greeting)();
        }
    }
}