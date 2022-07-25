<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Foundation\Request\Abstract;

use Nsavelev\Hw5\Foundation\Request\Exceptions\PropertyHasNotExistException;
use Nsavelev\Hw5\Foundation\RequestMessage\Interfaces\RequestMessageInterface;

abstract class BaseRequestAbstract
{
    public function __construct()
    {
        $requestMessage = $this->getRequestData();
        $messageBody = $requestMessage->getBody();

        $this->setParameters($messageBody);
    }

    /**
     * @return object
     */
    abstract protected function getRequestData(): RequestMessageInterface;

    /**
     * @param object $requestData
     * @return void
     * @throws PropertyHasNotExistException
     */
    private function setParameters(object $requestData): void
    {
        $reflectionClass = new \ReflectionClass(static::class);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property)
        {
            $propertyName = $property->getName();

            if (!property_exists($requestData, $propertyName)) {
                throw new PropertyHasNotExistException("Request has not '$propertyName' parameter");
            }

            $property->setValue($this, $requestData->$propertyName);
        }
    }
}