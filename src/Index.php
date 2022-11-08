<?php

namespace Dkozlov\Otus;

use Dkozlov\OtusPackage\Welcome;

class Index
{
    private $welcome;

    public function __construct()
    {
        $this->welcome = new Welcome();
    }
}