<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp\Core;

class Request
{
    /**
     * @param $field
     * @return array|mixed|null
     */
    public function request($field = null)
    {
        if (!$field) {
            return $_REQUEST;
        }

        return $_REQUEST[$field] ?? null;
    }
}