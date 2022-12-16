<?php
namespace app\components;

class Request {

    public static function get($value) {
        return $_GET[$value];
    }

    public static function post($value) {
        return $_POST[$value];
    }
}
