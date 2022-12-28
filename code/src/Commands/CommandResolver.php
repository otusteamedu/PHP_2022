<?php

namespace Ppro\Hw13\Commands;

use Ppro\Hw13\Register;

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
            'add','-a' => new AddCommand(),
            'find','-f' => new FindCommand(),
            'remove','--rm' => new RemoveCommand(),
            default => new InitCommand(),
        };
    }
}