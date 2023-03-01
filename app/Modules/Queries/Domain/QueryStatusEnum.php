<?php

declare(strict_types=1);

namespace App\Modules\Queries\Domain;

enum QueryStatusEnum: string
{
    case created = 'Создан';
    case processed = 'Обрабатывается';
    case ready = 'Обработан';
}
