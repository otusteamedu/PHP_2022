<?php

namespace TemaGo\PostRequestValidator;

class Request
{
    private function getPostParams() : array
    {
        return $_POST;
    }

    public function __get($name)
    {
        $params = $this->getPostParams();
        if (isset($params[$name])) {
            return $params[$name];
        }
        return null;
    }
}
