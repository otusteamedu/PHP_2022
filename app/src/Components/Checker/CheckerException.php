<?php

namespace Nka\Otus\Components\Checker;

use Nka\Otus\Core\Exceptions\ApplicationException;

class CheckerException extends ApplicationException
{
    protected $message = 'Ошибка проверки';
}