<?php

namespace nka\otus\core;

use nka\otus\core\exceptions\WrongAttributeException;

class Component
{
    /**
     * @param array $params
     * @return bool
     * @throws WrongAttributeException
     */
    public function loadParams(array $params)
    {
        try {
            foreach ($params as $param => $value) {
                $this->$param = $value;
            }
        } catch (\Exception $e) {
            throw new WrongAttributeException($e->getMessage());
        }
        return true;
    }
}