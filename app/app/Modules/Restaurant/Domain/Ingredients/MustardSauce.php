<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain\Ingredients;

class MustardSauce implements Sauce
{
    public function getName(): string
    {
        return 'горчица';
    }
}
