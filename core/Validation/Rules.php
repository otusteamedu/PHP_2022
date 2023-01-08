<?php
declare(strict_types=1);

namespace Otus\Task10\Core\Validation;

use Otus\Task10\Core\Validation\Contract\RuleContract;

abstract class Rules implements RuleContract
{
    protected mixed $value;

    public function setValue(mixed $value)
    {
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}