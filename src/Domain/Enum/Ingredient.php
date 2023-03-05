<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum Ingredient
{
    case BUN;
    case BREAD;
    case BEEF;
    case PORK;
    case SAUSAGE;
    case CHEESE;
    case CHICKEN;
    case LETTUCE;
    case MAYONNAISE;
    case KETCHUP;
}