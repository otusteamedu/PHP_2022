<?php

namespace hw4\core\exceptions;

class RouteNotFoundException extends ApplicationException
{
    protected $message = 'Route not found';
}