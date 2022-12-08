<?php

namespace Ppro\Hw12\Commands;

class CommandResolver
{
    /** Выбор
     * @return Command
     * @throws \Exception
     */
    public static function getCommand(): Command
    {
        if(!isset($_SERVER['argv'][1]))
            throw new \Exception("Not defined app role\r\n");
        return match (strtolower($_SERVER['argv'][1])) {
            "bulk", "-b" => new BulkCommand(),
            "delete", "-rm" => new DeleteCommand(),
            "filter", "-f" => new FilterCommand(),
            default => new DefaultCommand(),
        };
    }
}