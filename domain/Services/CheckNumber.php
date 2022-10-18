<?php

declare(strict_types=1);

namespace Domain\Services;

use Domain\ValueObjects\Number;

class CheckNumber
{
    protected $number;

    /**
     * @param $number
     */
    public function __construct(Number $number)
    {
        $this->number = $number;
    }

    public function checkPrime() : bool
    {
        //Реализован простейший алгорит, который может занимать много времени! Специально для тестирования очередей. Перепеолнение типов не учитываю!
        if ($this->number->getNumber() == 1)
            return false;

        for ($i = 2; $i <= ($this->number->getNumber()/2); $i++){
            if (($this->number->getNumber() % $i == 0))
                return false;
        }
        return true;
    }
}
