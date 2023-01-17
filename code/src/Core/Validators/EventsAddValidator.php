<?php


namespace Decole\Hw13\Core\Validators;


use Decole\Hw13\Core\Validators\SubValidators\IsArrayKeyExistValidator;
use Decole\Hw13\Core\Validators\SubValidators\IsArrayValidator;
use Decole\Hw13\Core\Validators\SubValidators\IsEmptyStringValidator;
use Decole\Hw13\Core\Validators\SubValidators\IsIntegerValidator;
use Decole\Hw13\Core\Validators\SubValidators\IsNullValidator;

class EventsAddValidator implements ValidatorInterface
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

        foreach ($this->value as $event) {
            $this->validateInjectingEvent($event);
        }
    }

    private function validateInjectingEvent(array $event): void
    {
        $this->isExistPriority($event);
        $this->isExistConditions($event);
        $this->isExistParamEvent($event);
    }

    private function isExistPriority(array $event): void
    {
        if (!IsArrayKeyExistValidator::validate(['priority', $event])) {
            $this->addError(['priority' => 'param not exist']);
            return;
        }

        if (IsNullValidator::validate($event['priority'])) {
            $this->addError(['priority' => 'is null']);
        }

        if (!filter_var($event['priority'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]])) {
            $this->addError(['priority' => 'is not integer']);
        }

        if (!IsIntegerValidator::validate($event['priority'])) {
            $this->addError(['priority' => 'is not integer']);
        }
    }

    private function isExistConditions(array $event): void
    {
        if (!IsArrayKeyExistValidator::validate(['conditions', $event])) {
            $this->addError(['conditions' => 'param not exist']);
            return;
        }

        if (IsNullValidator::validate($event['conditions'])) {
            $this->addError(['priority' => 'is null']);
        }

        if (!IsArrayValidator::validate($event['conditions'])) {
            $this->addError(['conditions' => 'is not object with params']);
        }
    }

    private function isExistParamEvent(array $event): void
    {
        if (!IsArrayKeyExistValidator::validate(['event', $event])) {
            $this->addError(['event' => 'param not exist']);
            return;
        }

        if (!IsArrayKeyExistValidator::validate(['type', $event['event']])) {
            $this->addError(['event.type' => 'param not exist']);
            return;
        }

        if (IsNullValidator::validate($event['event']['type'])) {
            $this->addError(['event.type' => 'is null']);
        }

        if (IsEmptyStringValidator::validate($event['event']['type'])) {
            $this->addError(['event.type' => 'is empty string']);
        }
    }
}