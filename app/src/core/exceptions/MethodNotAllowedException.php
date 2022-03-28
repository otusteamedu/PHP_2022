<?php

namespace hw4\core\exceptions;

class MethodNotAllowedException extends ApplicationException
{
    protected $message = 'Method not allowed';
}