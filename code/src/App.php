<?php
namespace Roman\Hw4;
class App
{
    private $string;

    public function __construct(){
        if(isset($_POST['string'])){
            $this->string=$_POST['string'];
        }
    }

    public function run(){
        if(!$this->check()){
            header("HTTP/1.0 400 Bad Request");
            echo 'Некорректно';
            die;
        }else{
            header("HTTP/1.0 200 OK");
            echo 'Корректно';
            die;
        }
    }

    private function check(){
        if(!isset($_POST['string']) || strlen($_POST['string'])==0){
           return false;
        }
        if(strlen($this->string)%2!=0){
            return false;
        }

        $arr=str_split($this->string);
        if($arr[0]==')' || $arr[strlen($this->string)-1]=='('){
            return false;
        }
        $count=0;
        foreach($arr as $item){
            if($count<0){
                $count=-1;
                break;
            }
            if($item=='('){
                $count++;
            }else{
                $count--;
            }
        }
        if($count!=0){
            return false;
        }
        return true;
    }
}