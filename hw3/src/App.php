<?php

declare(strict_types = 1);

namespace VeraAdzhieva\Hw3;

use VeraAdzhieva\Hw3\Service\Age;
use VeraAdzhieva\RectangleCalculate\RectangleCalculate;

class App
{
    /** @var Age */
    private $age;

    /**
     * App constructor.
     * @param Age $age
     */
    public function __construct(Age $age)
    {
        $this->age = $age;
    }

    public function run() {
        $rectangle = new RectangleCalculate();
        $lengthRectangle = 5;
        $widthRectangle = 10;
        echo "Использование своей библиотеки.";
        echo "\nПериметр прямоугольника = "  . $rectangle->getPerimeter($lengthRectangle, $widthRectangle);
        echo "\nПлощадь прямоугольника = " . $rectangle->getSquare($lengthRectangle, $widthRectangle);
        echo "\nДиагональ прямоугольника = " . $rectangle->getDiagonal($lengthRectangle, $widthRectangle);
        echo "\nИспользование библиотеки Carbon.";
        printf("\nВозраст: %s", $this->age->getAge(1999, 3, 30));
        printf("\nВремя сейчас: %s", $this->age->getDate());
    }
}