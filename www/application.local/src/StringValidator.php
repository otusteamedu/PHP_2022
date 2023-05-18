<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw4;

class StringValidator {

    /**
     * 
     * @param string $string
     * @return bool
     */
    public function is_valid_parenthesis(string $string = ')('): bool {
        while (($position = strpos($string, '()')) !== false) {
            $string = substr($string, 0, $position) . substr($string, $position + 2);
        }
        $result = $string === '';
        return $result;
    }

}
