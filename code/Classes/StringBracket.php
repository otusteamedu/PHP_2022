<?php

namespace Classes;

use Classes\Exceptions\EmptyStringException;
use Classes\Exceptions\WrongBracketsException;

class StringBracket
{
    private $string;

    /**
     * StringBracket constructor.
     *
     * @param $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * Check the string.
     *
     * @return void
     * @throws EmptyStringException|WrongBracketsException
     */
    public function check()
    {
        $this->checkNotEmpty();

        $this->checkBrackets();
    }

    /**
     * Check, the string is not empty.
     *
     * @return void
     * @throws EmptyStringException
     */
    public function checkNotEmpty()
    {
        if (!is_string($this->string) || empty($this->string)) {
            throw new EmptyStringException();
        }
    }

    /**
     * Check, the string is not empty.
     *
     * @return void
     * @throws WrongBracketsException
     */
    public function checkBrackets()
    {
        $count = 0;

        for ($i = 0; $i < strlen($this->string); $i++) {
            if ($this->string[$i] === '(') {
                $count++;
            }

            if ($this->string[$i] === ')') {
                $count--;
            }

            if ($count < 0) {
                throw new WrongBracketsException();
            }
        }

        if ($count !== 0) {
            throw new WrongBracketsException();
        }
    }
}
