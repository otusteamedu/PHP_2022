<?php

declare(strict_types=1);

namespace Chernysh\Hw4;

use Chernysh\Hw4\Service\ServiceException;

class App
{
    public function run(): string
    {
        try {
            $service = new \Chernysh\Hw4\Service\CheckStringService();
            $service->check($_REQUEST ?? []);
            http_response_code(200);
            return "Всё хорошо";
        } catch (ServiceException $e) {
            http_response_code(400);
            return "Всё плохо: " . $e->getMessage();
        }
    }
}
