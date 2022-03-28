<?php

namespace nka\otus\core\exceptions;

class MethodNotAllowedException extends ApplicationException
{
    protected $message = 'Method not allowed';
}