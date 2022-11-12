<?php

namespace app\helpers;

use Exception;

class BracketsHelper {
    public string $string;

    /**
     * @throws Exception
     */
    public function __construct(string $sting) {
        $this->string = $sting;
    }

    /**
     * @throws Exception
     */
    public function validateString() {
        $this->checkBracketsOnly();
        $this->checkCouplesCorrect();
    }

    /**
     * @throws Exception
     */
    private function checkBracketsOnly() {
        $wrongSymbols = preg_replace('/\(|\)/', '', $this->string);
        if (!empty($wrongSymbols)) {
            throw new Exception('Неверный запрос. Присутствуют символы, отличные от скобок: '.$wrongSymbols, 400);
        }
    }

    /**
     * @throws Exception
     */
    private function checkCouplesCorrect() {
        $remainder = $this->withoutBracketsCouples($this->string);
        if (!empty($remainder)) {
            throw new Exception('Неверный запрос. Заберите лишние скобки: '.$remainder, 400);
        }
    }

    private function withoutBracketsCouples($str) {
        $coupleCount = substr_count($str, '()');
        if ($coupleCount > 0) {
            $str = str_replace('()', '', $str);
            return $this->withoutBracketsCouples($str);
        }
        return $str;
    }
}
