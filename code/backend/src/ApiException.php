<?php
namespace Socket;

use Exception;

class ApiException extends Exception
{
    static public function exception(): string
    {
        return "";
    }
}
