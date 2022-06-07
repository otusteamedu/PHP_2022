<?php

namespace Katya\App\Controllers;

use \Katya\App\Users\Controller;

class UserController extends Controller
{
    private function getString()
    {
        $post = $_POST;
        $string = $post['string'];
        if (!empty($string)) return $string;
        else {
            $data='Тут пусто';
            echo $this->getTemplate('mistake.php', $data);
        }
    }
    public function isClosedBracket(string $bracket, array $stack)
    {
        $closeBrackets=[')','}',']','>'];
        if (in_array($bracket, $closeBrackets)){
            return true;
        } else return false;
    }
    public function isValid(){
        $string = $this->getString();
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

    public function getAnswer(){
        if ($this->isValid()) {
            $data='Все ок';
        }else {
            $data='последовательность скобок нарушена';
        }
        echo $this->getTemplate('mistake.php', $data);
    }
}