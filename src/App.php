<?php

declare(strict_types=1);

namespace Sveta\Php2022;

use Svatelnet\MyLibrary\ReverseService;

class App
{
    public function __construct(
        private ReverseService $reverseService
    ) {
    }

    public function run()
    {
        echo $this->reverseService->reverse('string');
    }
}