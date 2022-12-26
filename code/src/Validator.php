<?php

declare(strict_types=1);

namespace Maldoshina\StringValidator;

class Validator
{
    /**
     * @param $string
     *
     * @return string
     */
    public function validateBrackets($string): string
    {
        if (!$string) {
            throw new \Exception('Строка пуста', 400);
        }

        $counter = 0;
        foreach (str_split($string) as $symbol) {
            if ($symbol == '(') {
                $counter++;
            }

            if ($symbol == ')') {
                $counter--;
            }

            if ($counter < 0) {
                throw new \Exception('Строка не валидна', 400);
            }
        }

        return "Строка валидна";
    }
}
