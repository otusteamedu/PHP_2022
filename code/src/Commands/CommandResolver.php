<?php

namespace Ppro\Hw7\Commands;

class CommandResolver
{
    /** Выбор
     * @return Command
     * @throws \Exception
     */
    public static function getCommand(): Command
    {
        if(!isset($_SERVER['argv'][1]))
            throw new \Exception("Not defined app role");
        return match ($_SERVER['argv'][1]) {
            "server" => new ServerCommand(),
            "client" => new ClientCommand(),
            default => new DefaultCommand(),
        };
    }
}