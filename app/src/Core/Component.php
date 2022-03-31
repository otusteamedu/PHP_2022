<?php

namespace Nka\Otus\Core;

use Nka\Otus\Core\Exceptions\WrongAttributeException;

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