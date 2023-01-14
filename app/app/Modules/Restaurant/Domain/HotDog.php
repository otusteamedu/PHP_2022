<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain;

use App\Modules\Restaurant\Domain\Ingredients\HotDogBun;
use App\Modules\Restaurant\Domain\Ingredients\Onion;
use App\Modules\Restaurant\Domain\Ingredients\Sauce;
use App\Modules\Restaurant\Domain\Ingredients\Sausage;

class HotDog extends Burger
{
    private ?HotDogBun $bun = null;
    private ?Sausage $sausage = null;
    private ?Onion $onion = null;
    private ?Sauce $sauce = null;

    public function __construct(HotDogBuilder $builder)
    {
        $this->bun = $builder->bun;
        $this->sausage = $builder->sausage;
        $this->onion = $builder->onion;
        $this->sauce = $builder->sauce;
    }

    public function getTitle(): string
    {
        return 'Хотдог';
    }

    public function getComposition(): string
    {
        $positions = [
            $this->bun->getName(),
            $this->sausage->getName(),
            $this->onion->getName(),
            $this->sauce->getName()
        ];

        return implode(', ', $positions);
    }
}
