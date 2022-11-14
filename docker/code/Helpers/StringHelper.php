<?php

namespace Waisee\StringVerification\Helpers;

class StringHelper
{
    public function verify(?string $string): bool
    {
        if ($string === null) {
            return false;
        }
        $counter = 0;
        for ($i = 1; $i < strlen($string); $i++){
            if ($string[$i] === '(') {
                $counter++;
            }
            else {
                $counter--;
            }
            if ($counter < 0) {
                return false;
            }
        }
        return $counter === 0;
    }
}