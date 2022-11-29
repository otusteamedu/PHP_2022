<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\Exception;

use Nikcrazy37\Hw6\App\Config;

class EmptyAppNameException extends AppException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Пустое имя приложение. Введите один из вариантов:\nphp app.php [" . Config::getAppNameString() . "]";

        parent::__construct($message, $code, $previous);
    }
}