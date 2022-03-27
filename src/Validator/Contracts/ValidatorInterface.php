<?php

namespace App\Validator\Contracts;

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
