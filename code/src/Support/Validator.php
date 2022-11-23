<?php

namespace Koptev\Support;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;

class Validator
{
    /**
     * Data for validation.
     *
     * @var array
     */
    private array $data;

    /**
     * Validation rules.
     *
     * @var array
     */
    private array $rules;

    /**
     * Validation errors.
     *
     * @var array
     */
    private array $errors;

    /**
     * Set data for validation.
     *
     * @param array $data
     * @return Validator
     */
    public function setData(array $data): Validator
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set validation rules.
     *
     * @param array $rules
     * @return Validator
     */
    public function setRules(array $rules): Validator
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Set validation rules.
     *
     * @return bool
     */
    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->data as $key => $value) {
            foreach ($this->rules[$key] ?? [] as $rule) {
                $functionName = 'validation_' . $rule;

                if (!$this->$functionName($value)) {
                    $this->errors[$key][] = 'Error validation rule \'' . $rule . '\'';
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Get errors.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Validate by rule 'required'.
     *
     * @param $value
     * @return bool
     */
    private function validation_required($value): bool
    {
        return !empty($value);
    }

    /**
     * Validate by rule 'email'.
     *
     * @param string $value
     * @return bool
     */
    private function validation_email(string $value): bool
    {
        $emailValidator = new EmailValidator();

        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false
            && $emailValidator->isValid($value, new DNSCheckValidation());
    }
}
