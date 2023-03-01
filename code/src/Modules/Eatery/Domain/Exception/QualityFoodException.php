<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Exception;

use Nikcrazy37\Hw14\Libs\Exception\DomainException;

class QualityFoodException extends DomainException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "$message isn't quality!";

        parent::__construct($message, $code, $previous);
    }
}