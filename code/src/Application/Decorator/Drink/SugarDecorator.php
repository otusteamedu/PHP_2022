<?php

declare(strict_types=1);

namespace App\Application\Decorator\Drink;

use App\Application\Decorator\ComponentDecorator;

/**
 * SugarDecorator
 */
class SugarDecorator extends ComponentDecorator
{
    /**
     * @var string
     */
    protected string $ingredient = 'Сахар';
}