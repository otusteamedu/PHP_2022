<?php

namespace Waisee\StringVerification\Helpers;

class StringHelper
{
    public function verify(?string $string): int
    {
        if ($string === null) {
            return http_response_code(400);
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
                return http_response_code(400);
            }
        }
        return $counter === 0 ? http_response_code(200) : http_response_code(400);
    }
}