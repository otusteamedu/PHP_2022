<?php

namespace App\Validator\Interfaces;

interface ValidatorInterface
{    
    /**
     * validate
     *
     * @param  mixed $value
     * @return bool
     */
    public function validate(string $value): bool;
}