<?php

declare(strict_types=1);

namespace Philip\Otus\Core;

use Philip\Otus\Core\View\Greeting;
use Philip\Otus\Core\View\CheckBrackets;

class Dispatcher
{
    const VIEW_GREETING = 'greeting';
    const VIEW_CHECK_BRACKETS = 'check_brackets';

    public function dispatch(string $key)
    {
        if($key === self::VIEW_GREETING) {
            return (new Greeting)();
        }
        if($key === self::VIEW_CHECK_BRACKETS) {
            return (new CheckBrackets)();
        }
    }
}