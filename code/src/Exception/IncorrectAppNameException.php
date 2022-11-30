<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\Exception;

use Nikcrazy37\Hw6\App\Config;

class IncorrectAppNameException extends AppException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $appName = Config::getStringFromArray("APP_NAME");
        $message = "Неверное имя приложения. Введите один из вариантов:\nphp app.php [" . $appName . "]";

        parent::__construct($message, $code, $previous);
    }
}