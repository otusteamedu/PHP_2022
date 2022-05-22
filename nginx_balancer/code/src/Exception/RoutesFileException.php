<?php
declare(strict_types=1);
namespace Mapaxa\BalancerApp\Exception;

use Exception;
use Throwable;

final class RoutesFileException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        if (!$message) {
            $message = 'Файл с роутами не существует или не доступен';
        }

        parent::__construct($message, $code);
    }

}