<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain\Ingredients;

class KetchupSauce implements Sauce
{

    public function getName(): string
    {
       return 'кетчуп';
    }
}
