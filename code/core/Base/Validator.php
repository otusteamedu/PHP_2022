<?php

namespace Core\Base;

use Core\Exceptions\InvalidArgumentException;

class Validator
{
    protected array $rules = [
        'required',
        'email',
        'brackets'
    ];

    protected array $errors = [];

    /**
     * @param $value
     * @param array $rules
     * @return void
     * @throws InvalidArgumentException
     */
    public function validated($value, array $rules) :void
    {
        foreach ($rules as $rule) {
            if (!in_array($rule, $this->rules, true)) {
                throw new InvalidArgumentException("rules: {$rule} is not exist");
            }

            $this->validateFunction($value, $rule);
        }
    }

    /**
     * @param $value
     * @param string $rule
     * @return void
     */
    protected function validateFunction($value,string $rule) :void
    {
        switch ($rule) {
            case 'required':
                $this->requiredRule($value);
                break;
            case 'email':
                $this->isEmail($value);
                break;
            case 'brackets':
                $this->bracketRule($value);
                break;
        }
    }

    /**
     * @param $value
     * @return void
     */
    protected function requiredRule($value) :void
    {
        if (empty($value)) {
            $this->setError('The field is required.');
        }
    }

    /**
     * @param string $value
     * @return void
     */
    protected function bracketRule(string $value) :void
    {
        $prev = '';
        $replaced = $value;
        $reg = '/\(\)|\[\]|\{\}/';

        while ($replaced !== $prev) {
            $prev = $replaced;
            $replaced = preg_replace($reg, '', $replaced);
        }

        if($prev !== '') {
            $this->setError('Error check brackets');
        }
    }

    /**
     * @param string $value
     * @return void
     */
    protected function isEmail(string $value) :void
    {
        if (!(bool)filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->setError('The email must be a valid email address.');
        }
    }

    /**
     * @return bool
     */
    public function check() :bool
    {
        return count($this->getErrors()) === 0;
    }

    /**
     * @param string $error
     * @return void
     */
    protected function setError(string $error) :void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors() :array
    {
        return $this->errors;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getErrorsToString(string $separator = '|') :string
    {
        return implode($separator, $this->errors);
    }
}