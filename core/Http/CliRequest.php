<?php

namespace Otus\Task06\Core\Http;


class CliRequest extends Request
{

    private array $arguments;
    protected string $path;
    public function initialize(){
        $this->arguments = $_SERVER['argv'];
    }

    public function getPath()
    {
        return $this->arguments[1];
    }
}