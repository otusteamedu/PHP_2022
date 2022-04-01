<?php

namespace Nka\Otus\Core\Exceptions;

class TeapotException extends ApplicationException
{
    protected $message = 'I\'m a teapot';
    protected $code = 418;
}
