<?php

declare(strict_types=1);

namespace Domain\ValueObjects;

//Целое число!
class Number
{
    protected $i;

    /**
     * @param $i
     */
    public function __construct($i)
    {
        if (is_int($i))
            $this->i = $i;
        else
            Throw new DomainException("Not an integer!");
    }

    /**
     * @return mixed
     */
    public function getNumber() : int
    {
        return $this->i;
    }



}
