<?php

namespace Katya\App\Controllers;

use \Katya\App\Users\Controller;

class UserController extends Controller
{

    public function isClosedBracket($bracket):bool
    {
        $closeBrackets=[')','}',']','>'];
        if (in_array($bracket, $closeBrackets)){
            return true;
        } else return false;
    }
    public function isValid($string):bool
    {
        $len =strlen($string);
        $stack=[];
        $bracket = ["]" => "[", "}" => "{", ")" => "(", ">"=>"<"];
        for ($i = 0; $i < $len; $i++) {
            if($this->isClosedBracket($string[$i])){
                if(array_pop($stack) !== $bracket[$string[$i]]) {
                    return false;
                } }
            else $stack[] = $string[$i];
        }
        return empty($stack);
    }

    public function getAnswer():string
    {
        $string = $_POST['string'];
        if (!empty($string)){
            if ($this->isValid($string)) {
                http_response_code(200);
                $answer = "ваша последовательность великолепна!";
            }else {
                http_response_code(400);
                $answer = "не пусто, но последовательность скобок нарушена(";
            }
        }else{
            http_response_code(400);
            $answer= "тут пусто(";
        }
        echo $answer;
    }
}