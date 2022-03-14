<?php
declare(strict_types=1);

namespace Mapaxa\BalancerApp\Service;


class RoundBracesValidator {

    const LEFT_BRACE = '(';
    const RIGHT_BRACE = ')';

    public function isValid(string $string): bool
    {
        $counter = 0;

        if ($string[0] === self::RIGHT_BRACE || empty($string)) {
            return false;
        }

        for ($symbolOrderNumber = 0; $symbolOrderNumber < strlen($string); $symbolOrderNumber ++) {
            if (self::LEFT_BRACE == $string[$symbolOrderNumber]) {
                $counter++;
            } else {
                $counter--;
            }
        }

        return $counter == 0;
    }

}

