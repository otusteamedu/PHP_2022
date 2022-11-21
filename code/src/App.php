<?php

declare(strict_types=1);

namespace Chernysh\Hw4;

use Chernysh\Hw4\Service\ServiceException;

class App
{

    public function run(): void
    {
        $service = new \Chernysh\Hw4\Service\CheckStringService();

        try {
            $service->check($_REQUEST ?? []);
            http_response_code(200);
            echo "Всё хорошо";
        } catch (ServiceException $e) {
            http_response_code(400);
            echo "Всё плохо: " . $e->getMessage();
        }
    }

}