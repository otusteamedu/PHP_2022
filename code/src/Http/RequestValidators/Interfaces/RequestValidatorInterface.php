<?php

namespace Nsavelev\Hw4\Http\RequestValidators\Interfaces;

interface RequestValidatorInterface
{
    /**
     * @return void
     */
    public function validate(): void;
}