<?php

declare(strict_types=1);

namespace Chernysh\EmailVerification;

use Chernysh\EmailVerification\Service\ServiceException;
use Chernysh\EmailVerification\Service\ServiceInterface;

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
            echo 'ОК';
        } catch (ServiceException $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }

}