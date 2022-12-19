<?php


namespace Otus\Task06\Core\Validation\Contract;


interface ValidatorContract
{
    public static function make(string $value, array $rules) : self;
    public function isValid() : bool;
    public function getErrors(): array;
    public function __toString() : string;
}