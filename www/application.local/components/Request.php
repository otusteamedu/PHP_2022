<?php
namespace app\components;

use app\helpers\StringHelper;

class Request {

    public static function get($param, $is_required = true) {
        $r = $_GET[$param];
        if ($is_required && empty($r)) {
            throw new \Exception('Обязательный get параметр '.$param.' отсутствует.', 400);
        }
        return $_GET[$param];
    }

    public static function post($param, $is_required = true, $must_be_json = true) {
        $r = $_POST[$param];
        if ($is_required && empty($r)) {
            throw new \Exception('Обязательный post параметр '.$param.' отсутствует.', 400);
        }
        if ($must_be_json && !StringHelper::isValidJson($r)) {
            throw new \Exception('Параметр '.$param.' не является валидным JSON, хотя должен.', 400);
        }
        return $_POST[$param];
    }

}
