<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

class Sandwich extends BaseProduct
{
    public function show(): void
    {
        $image = <<<image
                    _.---._
                _.-~       ~-._
            _.-~               ~-._
        _.-~                       ~---._
    _.-~                                 ~\
 .-~                                    _.;
 :-._                               _.-~ ./
 }-._~-._                   _..__.-~ _.-~)
 `-._~-._~-._              / .__..--~_.-~
     ~-._~-._\.        _.-~_/ _..--~~
         ~-. \`--...--~_.-~/~~
            \.`--...--~_.-~
              ~-..----~
image;
        print_r($image);
    }
}