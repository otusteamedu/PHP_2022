<?php

namespace Ppro\Hw5;

class Validator
{
    private string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function run(): bool
    {
        return !$this->checkEmpty() && $this->checkBrackets();
    }

    /** Проверка на пустоту
     * @return bool
     */
    private function checkEmpty(): bool
    {
        return empty($this->string);
    }

    /** Проверка правильности скобочной последовательности
     * @return bool
     */
    private function checkBrackets(): bool
    {
        if (empty($this->string))
            return false;
        $arBrackets = (mb_str_split(preg_replace('/[^\(\)]/i', '', $this->string)));
        $counter = 0;
        foreach ($arBrackets as $bracket) {
            if ($bracket === '(')
                $counter++;
            else
                $counter--;
            if ($counter < 0) return false;
        }
        return $counter === 0;
    }
}