<?php
namespace Api;

use Exception;

class ApiException extends Exception
{
    static public function emptyPost(): string
    {
        return "Please provide appropriate POST data.";
    }
}
