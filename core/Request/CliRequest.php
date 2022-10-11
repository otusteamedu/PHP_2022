<?php

namespace Otus\Core\Request;

class CliRequest
{
    private ?string $commandName = null;

    public function init()
    {
        $args = $_SERVER ["argv"];
        $this->commandName = $args[1] ?? null;
    }

    public function getCommandName(): ?string
    {
        return $this->commandName;
    }
}