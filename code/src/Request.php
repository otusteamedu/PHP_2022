<?php

namespace Ppro\Hw15;

class Request
{
    private $cmd;
    public function __construct()
    {
        $this->cmd = strtolower($_SERVER['argv'][1] ?? '');
    }

    public function getCmd(): string
    {
        return $this->cmd;
    }
}