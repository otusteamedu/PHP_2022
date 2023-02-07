<?php

namespace app\validators;

interface ValidatorInterface
{
    public function validate(): bool;
    public function getError(): string;
}
