<?php

declare(strict_types=1);

namespace App\App\Elastic;

enum RangeCondition: string
{
    case gt = 'gt';
    case gte = 'gte';
    case lt = 'lt';
    case lte = 'lte';
}