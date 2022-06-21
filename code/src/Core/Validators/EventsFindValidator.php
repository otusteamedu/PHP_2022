<?php


namespace Decole\Hw13\Core\Validators;


use Decole\Hw13\Core\Validators\SubValidators\IsArrayKeyExistValidator;

class EventsFindValidator implements ValidatorInterface
{
    public function __construct(private mixed $value, private array $errors = [], private bool $status = true)
    {
    }

    public function validate(): bool
    {
        $this->processing();

        return $this->status;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function addError(array $error): void
    {
        $this->status = false;
        $this->errors[] = $error;
    }

    private function processing(): void
    {
        if ($this->value === null || !is_array($this->value)) {
            $this->addError(['params' => 'is empty or not array params']);

            return;
        }

        $this->isExistParams($this->value);
    }

    public function isExistParams($value): void
    {
        if (!IsArrayKeyExistValidator::validate(['params', $value])) {
            $this->addError(['params' => 'params not exist']);
        }
    }
}