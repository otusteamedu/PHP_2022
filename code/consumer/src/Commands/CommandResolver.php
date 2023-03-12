<?php
declare(strict_types = 1);

namespace Ppro\Hw27\Consumer\Commands;

use Ppro\Hw27\Consumer\Application\Registry;

class CommandResolver
{
    public static function getCommand(): Command
    {
        $cmd = Registry::instance()->getRequest()->getCmd();
        return match ($cmd) {
            '--app' => new DefaultCommand(),
            '-m','--mail' => new SendMailCommand(),
            default => new DefaultCommand(),
        };
    }
}
