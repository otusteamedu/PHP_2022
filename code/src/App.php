<?php

declare(strict_types=1);

namespace src;

use src\Http\Request\RequestStatus;

final class App
{
    private RequestStatus $requestStatus;
    public function __construct(
        RequestStatus $requestStatus
    ) {
        $this->requestStatus = $requestStatus;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        if ($this->requestStatus->checkMethod($_SERVER)) {

        }
        throw new \Exception('Выберите тип метода');
    }
}