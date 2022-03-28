<?php

namespace Core\Traits;

trait ErrorTrait
{
    /**
     * @var array $errors
     */
    private array $errors = [];

    /**
     * @param $error
     * @return void
     */
    public function setError($error) :void
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
    public function getErrorsToString(string $separator = ' | ') :string
    {
        return implode($separator, $this->errors);
    }
}