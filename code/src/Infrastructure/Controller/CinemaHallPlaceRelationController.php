<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Domain\Entity\CinemaHall;
use Nikolai\Php\Domain\Entity\CinemaHallPlaceRelation;
use Nikolai\Php\Domain\Entity\Place;
use Nikolai\Php\Domain\Mapper\MapperInterface;
use Symfony\Component\HttpFoundation\Request;

class CinemaHallPlaceRelationController implements ControllerInterface
{
    public function __construct(private MapperInterface $mapper) {}

    public function __invoke(Request $request)
    {
        $place = new Place(null, 5, 55);
        $cinemaHall = $this->mapper->find(CinemaHall::class, 6);
        $cinemaHallPlaceRelation = new CinemaHallPlaceRelation(null, $cinemaHall, $place);

        echo 'До:' . PHP_EOL;
        var_dump($cinemaHallPlaceRelation);

        $cinemaHallPlaceRelation = $this->mapper->insert($cinemaHallPlaceRelation);

        echo 'После:' . PHP_EOL;
        var_dump($cinemaHallPlaceRelation);

/*
        $result = $this->mapper->find(CinemaHallPlaceRelation::class, 3);

        var_dump($result);
*/
    }
}