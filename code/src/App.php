<?php

declare(strict_types=1);

namespace Study\StringValidator;

use Study\StringValidator\Service\StringValidatorService;

class App
{
    private StringValidatorService $stringValidatorService;

    public function __construct(StringValidatorService $stringValidatorService)
    {
       $this->stringValidatorService = $stringValidatorService;
    }

    public function run(string $string)
    {
        return $this->stringValidatorService->validate($string);
    }
}