<?php


namespace Otus\Task11\Core\Validation\Contract;


interface RuleContract
{
    public function validate(): bool;
    public function setValue(mixed $value);
    public function getValue(): mixed;
    public function message(): string;
}