<?php
declare(strict_types=1);

namespace Otus\Task06\Core\Http;

abstract class Request
{
    protected string $path = '/';

    public function __construct()
    {
        $this->initialize();
    }

    abstract public function initialize();

    abstract public function getPath();

}