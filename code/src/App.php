<?php

declare(strict_types=1);

namespace Chernysh\Hw4;

use Chernysh\Hw4\Service\ServiceException;
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
        try {
            $this->service->check($_REQUEST ?? []);
            http_response_code(200);
            echo "Всё хорошо";
        } catch (ServiceException $e) {
            http_response_code(400);
            echo "Всё плохо: " . $e->getMessage();
        }
    }

}