<?php
declare(strict_types=1);

namespace PShilyaev;

class StringService
{
    public static function CheckString(string $s) : ?bool
    {
        if (preg_match("/[\(\)]/i", $s)!=1) {
            return NULL;
        }

        $openBracket = 0;
        for($i=0;$i<strlen($s);$i++) {

            if ($s[$i]=="(")
                $openBracket++;
            else {
                $openBracket--;
                if ($openBracket < 0)
                    return false;
            }
        }
        if ($openBracket>0)
            return false;
        else
            return true;
    }
}