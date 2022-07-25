<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Foundation\Request;

use Nsavelev\Hw5\Foundation\Request\Abstract\BaseRequestAbstract;
use Nsavelev\Hw5\Foundation\Request\Exceptions\RequestDataIsEmptyException;
use Nsavelev\Hw5\Foundation\RequestMessage\DTOs\MessageDTO;
use Nsavelev\Hw5\Foundation\RequestMessage\Interfaces\RequestMessageInterface;
use Nsavelev\Hw5\Foundation\RequestMessage\RequestMessageFactory;

class BaseInputRequest extends BaseRequestAbstract
{
    /**
     * @return RequestMessageInterface
     * @throws RequestDataIsEmptyException|\JsonException
     */
    protected function getRequestData(): RequestMessageInterface
    {
        $requestData = file_get_contents('php://input');

        if (empty($requestData)) {
            throw new RequestDataIsEmptyException('Request data is empty');
        }

        $requestData = json_decode($requestData, false, 512, JSON_THROW_ON_ERROR);

        $messageDTO = new MessageDTO();
        $messageDTO->setBody($requestData);

        $requestMessage = (new RequestMessageFactory())->createRequestMessage($messageDTO);

        return $requestMessage;
    }
}