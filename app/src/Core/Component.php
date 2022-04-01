<?php

namespace Nka\Otus\Core;

use Nka\Otus\Core\Exceptions\WrongAttributeException;

class Component implements Configurable
{
    protected Config $config;

    /**
     * @param $params
     * @return bool
     */
    public function loadParams(Config|array $params)
    {
        foreach ($params as $param => $value) {
            if (property_exists($this, $param)) {
                $this->$param = $value;
            }
        }
        return true;
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}