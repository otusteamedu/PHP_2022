<?php

namespace Api;

abstract class AbstractApi implements ApiInterface
{
    protected string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    abstract protected function analyze();
}
