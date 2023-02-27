<?php

declare(strict_types=1);

namespace Eliasj\Hw16\App\Exceptions;

use Throwable;

class NoAttributeException extends \Exception
{
    public function __construct(string $name, int $code = 0, ?Throwable $previous = null)
    {
        $message = "Attribute $name not exists";
        parent::__construct($message, $code, $previous);
    }
}
