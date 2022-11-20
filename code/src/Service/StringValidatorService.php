<?php

declare(strict_types=1);

namespace Study\StringValidator\Service;

class StringValidatorService
{
    public function validate(string $str): bool
    {
        if (empty($str) || preg_match("/^\(.*\)/", $str)) {

            return false;
        }

        $counter = 0;
        $length = strlen($str);

        for ($i = 0; $i < $length; $i++) {
            $bracket = $str[$i];

            if ($bracket === '(') {
                $counter++;
            } elseif ($bracket === ')') {
                $counter--;
            }
        }
        if ($counter !== 0) {
            return false;

        }
        return true;
    }

}