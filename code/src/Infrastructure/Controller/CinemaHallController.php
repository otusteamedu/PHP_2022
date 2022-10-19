<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Domain\Entity\CinemaHall;
use Nikolai\Php\Domain\Entity\CinemaHallPlaceRelation;
use Nikolai\Php\Domain\Mapper\MapperInterface;
use Nikolai\Php\Infrastructure\SqlBuilder\SqlBuilder;
use Symfony\Component\HttpFoundation\Request;


class CinemaHallController implements ControllerInterface
{
    public function __construct(private MapperInterface $mapper) {}

    public function __invoke(Request $request)
    {

        $cinemaHall = $this->mapper->find(CinemaHall::class, 7);
        var_dump($cinemaHall);

        $cinemaHallPlaceRelation = $this->mapper->findBy(CinemaHallPlaceRelation::class, ['id' => 5]);
        var_dump($cinemaHallPlaceRelation);

/*
        var_dump($cinemaHall->getCinemaHallPlaceRelation()->count());
        var_dump($cinemaHall);
*/
/*
        var_dump(SqlBuilder::select()->table('cinema_hall')
            ->where('a', 'b')
            ->where('c', 'd')
            ->build());
        var_dump(SqlBuilder::delete()->table('cinema_hall')
            ->where('a', 'b')
            ->where('c', 'd')
            ->build());
        var_dump(SqlBuilder::insert()->table('cinema_hall')->build());
        var_dump(SqlBuilder::update()->table('cinema_hall')
            ->where('a', 'b')
            ->where('c', 'qwerty')
            ->build());
*/
    }
}