<?php

declare(strict_types=1);

namespace Eliasj\Hw16\Modules\Form\Application;

use Eliasj\Hw16\Modules\Form\Domain\Queue;

class ConsumerAction
{
    public static function run()
    {
        (new Queue())->listenChannel();
    }
}
