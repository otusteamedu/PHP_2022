<?php

namespace nka\otus\core\exceptions;

class RouteNotFoundException extends ApplicationException
{
    protected $message = 'Route not found';
}