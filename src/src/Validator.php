<?php

namespace TemaGo\PostRequestValidator;

class Validator
{

    /**
     * Преобразование строки в массив символов
     *
     * @param string $text
     * @return array
     */
    private function splitData(string $text) : array
    {
        return mb_str_split($text);
    }

    /**
     * Валидация на количество открытых и закрытых скобок и верности их расположения в строке
     *
     * @param string $text
     * @return void
     * @throws \ErrorException
     */
    public function validate(string $text) : void
    {
        $split = $this->splitData($text);

        $temp = [];
        foreach ($split as $letter) {
            if ($letter != '(' && $letter != ')') {
                continue;
            }

            if (count($temp) == 0) {
                $temp[] = $letter;
            } elseif ($temp[count($temp) - 1] == '(' && $letter == ')') {
                unset($temp[count($temp) - 1]);
                $temp = array_values($temp);
            } else {
                $temp[] = $letter;
            }
        }

        if (count($temp)) {
            throw new \ErrorException('Некорректный параметр');
        }
    }
}
