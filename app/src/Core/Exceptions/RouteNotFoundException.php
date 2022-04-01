<?php

namespace Nka\Otus\Core\Exceptions;

class RouteNotFoundException extends ApplicationException
{
    protected $message = 'Route not found';
    protected $code = 404;
}