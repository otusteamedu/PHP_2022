<?php

namespace Nka\Otus\Components\Checker;

class CheckerService
{
    public function __construct(
        private CheckerInterface $Checker
    )
    {
    }

    /**
     * @param string $string
     * @return string
     * @throws CheckerException
     */
    public function check(string $string)
    {
        if (empty($string)) {
            throw new CheckerException('Строка пустая');
        }
        $Checker = $this->Checker;
        if (!$Checker->check($string)) {
            throw new CheckerException('Некорректная строка');
        }
        return 'Email корректный';
    }

}