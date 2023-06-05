<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Libs\Exception\Base;

use Nikcrazy37\Hw16\Libs\Exception\BaseException;

class FileNotFoundException extends BaseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "File \"$message\" not found!";

        parent::__construct($message, $code, $previous);
    }
}