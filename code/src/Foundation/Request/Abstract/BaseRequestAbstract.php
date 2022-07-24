<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Foundation\Request\Abstract;

use Nsavelev\Hw5\Foundation\Request\Exceptions\PropertyHasNotExistException;

abstract class BaseRequestAbstract
{
    public function __construct()
    {
        $requestData = $this->getRequestData();
        $this->setParameters($requestData);
    }

    /**
     * @return object
     */
    abstract protected function getRequestData(): object;

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