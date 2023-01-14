<?php

declare(strict_types=1);

namespace Chernysh\Hw4;

use Chernysh\Hw4\Service\FishService;

class App
{

    private FishService $fishService;


    public function __construct(FishService $fishService)
    {
        $this->fishService = $fishService;
    }

    public function run(): void
    {
        $this->fishService->getText();
    }

}