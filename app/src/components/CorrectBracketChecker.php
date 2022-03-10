<?php

namespace hw4\components;

class CorrectBracketChecker
{
    public function check(string $string)
    {
        if (!empty($string)) {
            $washedString = $this->washString($string);
            return $this->testString($washedString);
        }
        return false;
    }

    /**
     * В тз написано, что проверять только на пустоту
     * Поэтому допускаем, что могут быть другие символы
     * и вычищаем их
     * @param $string
     * @return string $string
     */
    public function washString($string)
    {
        return preg_replace('/[^()]/', '', $string);
    }

    /**
     * Скобочки - вполне корректные регулярные выражения
     * Поэтому мы проверяем их на корректность с помощью валидности regexp
     * @param $string
     * @return bool
     */
    public function testString($string)
    {
        if (!empty($string)) {
            set_error_handler(function() {}, E_WARNING);
            $result = preg_match("/$string/", 'test') !== false;
            restore_error_handler();
            return $result;
        }
        return false;
    }
}