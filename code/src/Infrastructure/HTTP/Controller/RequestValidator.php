<?php


namespace Study\Cinema\Infrastructure\HTTP\Controller;


use Study\Cinema\Infrastructure\Exception\ArgumentException;

class RequestValidator
{
    private array $errors;
    public function __construct()
    {
        $this->errors = [];
    }
    public function validate(string $method, array $params)
    {
        $method = $method.'Validate';
        return $this->$method($params);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    private function createValidate(array $params)
    {
        if(empty($params)) {
            array_push($this->errors,"Нет параметров для создания события.");
            return false;
        }
        if(empty($params['priority'])) {
              array_push($this->errors,"Нет параметра 'Приоритет' для создания события.");

        }
        if(empty($params['conditions'])) {
             array_push($this->errors,"Нет параметра 'Conditions' для создания события.");

        }
        if(empty($this->errors)){
            return true;
        }
        return false;

    }

    private function getValidate(array $params)
    {
        if(empty($params)) {
            array_push($this->errors,"Нет параметров для поиска события.");
            return false;
        }
        return true;

    }

}