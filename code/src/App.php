<?php

declare(strict_types=1);

namespace Chernysh\EmailVerification;

use Chernysh\EmailVerification\Service\{EmailVerification, ServiceException};

class App
{

    public function run(): string
    {
        try {
            $service = new EmailVerification();
            $service->check($_REQUEST ?? []);
            http_response_code(200);
            return 'ОК';
        } catch (ServiceException $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }

}