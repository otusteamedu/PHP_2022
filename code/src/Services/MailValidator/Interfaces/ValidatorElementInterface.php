<?php

namespace Nsavelev\Hw5\Services\MailValidator\Interfaces;

interface ValidatorElementInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function validate(array $data): array;
}