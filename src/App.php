<?php

namespace AKhakhanova\Hw3;

use AKhakhanova\Hw3\Service\StringService;

class App
{
    private StringService $stringService;

    public function __construct(StringService $stringService)
    {
        $this->stringService = $stringService;
    }

    public function run(): void
    {
        $string = 'LOWER CASE STRING';

        echo $this->stringService->convertString($string);
    }

}