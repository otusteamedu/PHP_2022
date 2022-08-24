<?php
namespace Api;

use Exception;

class ApiException extends Exception
{
    static public function exception(): string
    {
        return "";
    }
}
