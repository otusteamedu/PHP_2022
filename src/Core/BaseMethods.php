<?php

namespace Queen\App\Core;

class BaseMethods
{
    /**
     * @return bool
     */
    public static function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * @param string $key
     *
     * @return false|mixed
     */
    public static function getPost(string $key)
    {
        if (!empty($_POST[$key])) {
            return $_POST[$key];
        }
        return false;
    }
}
