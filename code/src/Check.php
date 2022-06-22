<?php

namespace Roman\Hw4;


class Check
{

    /**
     * @var string|mixed
     */
    private string $string;

    /**
     * @var int
     */
    private int $count = 0;

    /**
     *
     */
    public function __construct()
    {
        if (isset($_POST['string'])) {
            $this->string = $_POST['string'];
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function run():string
    {
        if (!$this->check()) {
            throw new \Exception('Некорректно');
        } else {
            header("HTTP/1.0 200 OK");
            return 'Корректно';
        }
    }

    /**
     * @return bool
     */
    private function check():bool
    {
        if ($this->check_post() || $this->check_strlen()) {
            return false;
        }

        $arr = str_split($this->string);
        if ($this->check_first_last($arr)) {
            return false;
        }

        $this->start_count($arr);
        return !($this->count != 0);
    }

    /**
     * @return bool
     */
    private function check_post():bool
    {
        return !(!isset($_POST['string']) || strlen($_POST['string']) == 0);
    }

    /**
     * @return bool
     */
    private function check_strlen():bool
    {
        return strlen($this->string) % 2 != 0;
    }

    /**
     * @param array $arr
     * @return bool
     */
    private function check_first_last(array $arr):bool
    {
        return $arr[0] == ')' || $arr[strlen($this->string) - 1] == '(';
    }

    /**
     * @param array $arr
     * @return void
     */
    private function start_count(array $arr):void
    {
        foreach ($arr as $item) {
            if ($this->count < 0) {
                $this->count = -1;
                break;
            }
            $item == '(' ? $this->count++ : $this->count--;
        }
    }

}