<?php

namespace App\Service\CookFood\Exception;

use Symfony\Component\HttpFoundation\Response;

class RecipeNotFoundException extends \Exception
{
    protected $code = Response::HTTP_NOT_FOUND;
}