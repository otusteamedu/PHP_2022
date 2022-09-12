<?php

namespace Otus\Mvc\Models;

use Otus\Mvc\Core\View;


class Mystring
{
    public $timestamps = false;

    public static function check()
    {

            $string = $_POST['filter_string'];
            $counter = 0;
            $openBracket = ['('];
            $closedBracket = [')'];
            $length = strlen($string);
            for($i = 0; $i<$length; $i++) {
                $char = $string[$i];
                if(in_array($char, $openBracket)) {
                    $counter ++;
                } elseif (in_array($char, $closedBracket)) {
                    $counter --;
                }
            }
            if($counter != 0) {
                return false;
            } else {
                return true;
            }

    }
}
    

