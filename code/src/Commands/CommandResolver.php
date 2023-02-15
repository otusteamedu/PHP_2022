<?php

namespace Ppro\Hw15\Commands;

use Ppro\Hw15\Register;

class CommandResolver
{
    /** Выбор
     * @return Command
     * @throws \Exception
     */
    public static function getCommand(): Command
    {
        $cmd = Register::instance()->getRequest()->getCmd();
        return match ($cmd) {
            'find','-f' => new FindCommand(),
            'check','-c' => new CheckCommand(),
            'exit','-e' => new ExitCommand(),
            default => new InitCommand(),
        };
    }
}