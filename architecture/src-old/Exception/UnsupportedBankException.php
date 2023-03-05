<?php

declare(strict_types=1);

namespace App\Exception;

/**
 * Исключение для ситуаций, когда анкета предназначена для банка, с которым у нас нет интеграции в данный момент
 */
class UnsupportedBankException extends \Exception
{
}
