<?php
declare(strict_types=1);

namespace Otus\Task06\App\Validation\Rules;

use Otus\Task06\Core\Validation\Rules;

class EmailRule extends Rules
{

    public function validate() : bool
    {
       return (bool)preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $this->getValue());
    }

    public function message() : string
    {
        return  sprintf('Почта "%s" не прошла валидацию.', $this->value) ;
    }

}