<?php

namespace hw4\core;

use hw4\core\exceptions\WrongAttributeException;

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