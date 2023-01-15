<?php
declare(strict_types=1);

namespace Otus\Task11\Core\Validation;

use Otus\Task11\Core\Validation\Contract\RuleContract;
use Otus\Task11\Core\Validation\Contract\ValidatorContract;

class Validator implements ValidatorContract, \Stringable
{
    private array $errors = [];

    protected function __construct(private mixed $value, private array $rules){}


    public static function make(mixed $value, array $rules): self
    {
        return new self($value, $rules);
    }

    public function isValid(): bool
    {

        if(!$this->errors) $this->process();

        return !count($this->errors);
    }

    private function process(): void
    {
        foreach ($this->rules as $rule)
        {
            if($rule instanceof RuleContract)
            {
                $rule->setValue($this->value);
                if(!$rule->validate()){
                    $this->errors[] = $rule->message();
                        break;
                }
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function __toString(): string
    {
        return implode('/',$this->errors);
    }

}