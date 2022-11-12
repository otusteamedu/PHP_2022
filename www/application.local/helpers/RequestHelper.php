<?php

namespace app\helpers;

use Exception;

class RequestHelper {
    private array $allowedMethods = ['POST', 'GET'];

    public function setAllowedMethods(array $methods) {
        $this->allowedMethods = $methods;
    }

    /**
     * @throws Exception
     */
    public function checkActualMethod(): void {
        $actualMethod = $_SERVER['REQUEST_METHOD'];
        if (!$this->isMethodAllowed($actualMethod)) {
            throw new Exception('Допустим только POST метод.', 405);
        }
    }

    public function isMethodAllowed(string $method): bool {
        return in_array($method, $this->allowedMethods);
    }

    /**
     * @throws Exception
     */
    public function getPostParamValue(string $paramName, $allowEmpty = false) {
        $str = $_POST[$paramName];
        if (!$allowEmpty && empty($str)) {
            throw new Exception('Пареметр '.$paramName.' в запросе пуст или отсутствует.', 400);
        }
        return $str;
    }
}
