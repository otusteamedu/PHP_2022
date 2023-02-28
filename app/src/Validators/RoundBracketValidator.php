<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Validators;

class RoundBracketValidator
{
    public function validate(string $string): bool
    {
        return $string && $this->existsOnlyRoundBrackets($string) && $this->checkBrackets($string);
    }

    private function existsOnlyRoundBrackets(string $string): bool
    {
        return !\preg_match('/[^()]/', $string);
    }

    private function checkBrackets(string $string): bool
    {
        $count = 0;
        $stringLength = \mb_strlen($string);
        for ($i = 0; $i < $stringLength; $i++) {
            if ($string[$i] === '(') {
                $count++;
            } else {
                $count--;
            }
            if ($count < 0) {
                return false;
            }
        }
        return $count === 0;
    }
}
