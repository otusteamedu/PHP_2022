<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Foundation\Request;

use Nsavelev\Hw5\Foundation\Request\Abstract\BaseRequestAbstract;
use Nsavelev\Hw5\Foundation\Request\Exceptions\RequestDataIsEmptyException;

class BaseInputRequest extends BaseRequestAbstract
{
    /**
     * @return object
     * @throws RequestDataIsEmptyException|\JsonException
     */
    protected function getRequestData(): object
    {
        $requestData = file_get_contents('php://input');

        if (empty($requestData)) {
            throw new RequestDataIsEmptyException('Request data is empty');
        }

        $requestData = json_decode($requestData, false, 512, JSON_THROW_ON_ERROR);

        return $requestData;
    }
}