<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

use Nikolai\Php\Exception\VerifierException;

class BracketsVerifier implements VerifierInterface
{
    const OPEN_BRACKET = '(';

    public function verify(?string $string): void
    {
        $counterOpenBrackets = 0;

        if (empty($string)) {
            throw new VerifierException('Пустое значение!');
        }

        if (!preg_match("/^[()]+$/", $string)) {
            throw new VerifierException('Недопустимые символы!');
        }

        foreach (str_split($string) as $symbol) {
            $symbol === self::OPEN_BRACKET ? $counterOpenBrackets++ : $counterOpenBrackets--;
            if ($counterOpenBrackets < 0) {
                throw new VerifierException('Некорректная строка!');
            }
        }

        if ($counterOpenBrackets != 0) {
            throw new VerifierException('Некорректная строка!');
        }
    }
}