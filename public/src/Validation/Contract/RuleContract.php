<?php


namespace Otus\Task\Validation\Contract;


interface RuleContract
{
    public function validate(): bool;
    public function setValue(mixed $value);
    public function getValue(): mixed;
    public function message(): string;
}