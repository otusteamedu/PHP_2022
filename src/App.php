<?php

declare(strict_types=1);

namespace Chernysh\Hw4;

use Chernysh\Hw4\Service\ServiceInterface;

class App
{

    private ServiceInterface $service;


    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    public function run(): void
    {
        // todo
    }

}