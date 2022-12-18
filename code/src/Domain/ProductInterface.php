<?php
declare(strict_types=1);

namespace Otus\App\Domain;

interface ProductInterface
{
    //Интерфейс для абстрактной фабрики
    public CONST TYPE_BURGER = 1;
    public CONST TYPE_SANDWICH = 2;
    public CONST TYPE_HOTDOG = 3;

    public function getName() : string;
}