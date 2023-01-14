<?php

declare(strict_types=1);

namespace App\Src\Controllers\Validators;

final class ControllerRequestValidator
{
    private array $request;

    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function validateAddEventRequest(): string
    {
        return $this->examination(needed_keys: [
            'key',
            'score',
            'conditions',
            'event_description'
        ]);
    }

    /**
     * @return string
     */
    public function validateDeleteAllEvents(): string
    {
        return $this->examination(needed_keys: [
            'key',
        ]);
    }

    /**
     * @return string
     */
    public function validateDeleteConcreteEvent(): string
    {
        return $this->examination(needed_keys: [
            'key',
            'conditions',
            'event_description'
        ]);
    }

    /**
     * @return string
     */
    public function validateGetAllEvents(): string
    {
        return $this->examination(needed_keys: [
            'key',
        ]);
    }

    /**
     * @return string
     */
    public function validateGetConcreteEvent(): string
    {
        return $this->examination(needed_keys: [
            'key',
            'conditions',
        ]);
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @param array $needed_keys
     * @return string
     */
    private function examination(array $needed_keys): string
    {
        foreach ($needed_keys as $needed_key) {
            if (!isset($this->request[$needed_key])) {
                return $needed_key . ' must be present in the request';
            }

            if (empty($this->request[$needed_key])) {
                return $needed_key . ' value must not be empty';
            }
        }

        return '';
    }
}
