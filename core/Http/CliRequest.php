<?php

namespace Otus\Task10\Core\Http;


class CliRequest extends Request
{

    protected string $path;
    public function initialize(){

        $this->setProperties($_SERVER['argv']);
    }

    public function getPath()
    {
        return $this->properties[1];
    }
}