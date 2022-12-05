<?php
declare(strict_types=1);

namespace Otus\Task\Validation\Rules;



use Otus\Task\Validation\Rules;

class BracketsRule extends Rules
{

    public function validate() : bool
    {

        $stack = [];
        for ($i = 0; $i <= strlen($this->getValue()) - 1; $i++) {
            $symbol = $this->getValue()[$i];

            if (!in_array($symbol, ['(', ')'])) {
                return false;
            }
            if ($symbol === '(') {
                $stack[] = $symbol;
            } else {
                array_pop($stack);
            }
        }

        return count($stack) === 0;
    }

    public function message() : string
    {
        return  sprintf('Срока "%s" не прошла валидацию.', $this->value) ;
    }

}