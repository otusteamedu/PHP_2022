<?php

declare(strict_types=1);

namespace Philip\Otus\Validators;

use RuntimeException;
use Philip\Otus\Validators\Helpers\ErrorBag;
use Philip\Otus\Validators\Rules\RuleInterface;
use Philip\Otus\Validators\Helpers\ErrorBagInterface;

class Validator
{
    private ErrorBagInterface $errorBag;

    public function __construct(ErrorBagInterface $errorBag)
    {
        $this->errorBag = $errorBag;
    }

    public static function instance(): self
    {
        return new self(new ErrorBag());
    }

    public function validate(array $listRules, array $data): bool
    {
        $this->errorBag->clear();
        foreach ($listRules as $field => $rules) {
            foreach ($rules as $rule) {
                if (!($rule instanceof RuleInterface)) {
                    throw new RuntimeException('Rule is invalidate');
                }
                if ($rule->make($data[$field] ?? null) === false) {
                    foreach ($rule->fail() as $error) {
                        $this->errorBag->add($field, $error);
                    }
                    break;
                }
            }
        }
        return $this->errorBag->hasErrors() === false;
    }

    public function errors(): ErrorBag
    {
        return $this->errorBag;
    }
}