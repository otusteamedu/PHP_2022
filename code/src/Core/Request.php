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
            return $_POST;
        }

        if (isset($_POST[$field])) {
            return $_POST[$field];
        }

        throw new Exception('Поле ' . $field . ' не должно быть пустым!');
    }

    public function isPost(): bool
    {
        return !empty($_POST);
    }
}