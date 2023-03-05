<?php

declare(strict_types=1);

namespace App\Application\Service;

/**
 * Типы проверки валидности email адреса
 */
enum EmailVerifierMode
{
    /** Проверка только регулярным выражением */
    case REGEXP_ONLY;

    /** Проверить наличие MX записи */
    case WITH_MX_CHECKING;
}