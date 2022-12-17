<?php

namespace app\helpers;

class StringHelper {

    public static function isValidJson($str = NULL): bool {
        if (is_string($str)) {
            @json_decode($str);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }

}
