<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

class HotDog extends BaseProduct
{
    public function show(): void
    {
        $image = <<<image
  _                   _
 ( \                 / )
  \ \.-------------./ /
   \(               )/
     `.___________.'

image;
        print_r($image);
    }
}