<?php

namespace Nka\Otus\Core\Http\Headers;

interface HeaderInterface
{
    public function getField();

    public function getValue();

    public function __toString();
}