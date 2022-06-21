<?php


namespace Decole\Hw13\Core\Validators;


interface ValidatorInterface
{
    public function validate(): bool;

    public function getErrors(): array;
}