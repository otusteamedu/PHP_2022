<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain\Ingredients;

class HotDogBun implements Bun
{
    public function getName(): string
    {
      return 'Булочка для хот-дога';
    }
}
