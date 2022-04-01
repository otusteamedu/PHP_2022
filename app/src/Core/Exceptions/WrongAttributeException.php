<?php

namespace Nka\Otus\Core\Exceptions;

class WrongAttributeException extends CoreException
{
    protected $message = 'Wrong attribute';
    protected $code = 400;
}