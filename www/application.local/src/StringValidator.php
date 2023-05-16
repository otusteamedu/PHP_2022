<?php

namespace Rehkzylbz\OtusHw4;

class StringValidator {

    public function is_valid_parenthesis(string $string = ')('): bool {
        while (($position = strpos($string, '()')) !== false) {
            $string = substr($string, 0, $position) . substr($string, $position + 2);
        }
        $result = $string === '';
        return $result;
    }

}
