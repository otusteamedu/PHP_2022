<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp\Core;

use Exception;

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

        if (isset($_REQUEST[$field]) && !empty($_REQUEST[$field])) {
            return $_REQUEST[$field];
        }

        throw new Exception('Поле ' . $field . ' не должно быть пустым!');
    }
}