<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Domain\Entity\CinemaHall;
use Nikolai\Php\Domain\Mapper\MapperInterface;
use Symfony\Component\HttpFoundation\Request;

class LazyLoadCollectionController implements ControllerInterface
{
    public function __construct(private MapperInterface $mapper) {}

    public function __invoke(Request $request)
    {
        $cinemaHall = $this->mapper->find(CinemaHall::class, 1);

        fwrite(STDOUT, 'Извлекли кинозал с id: 1.' . PHP_EOL);
        fwrite(STDOUT, 'Коллекции: cinemaHallPlaceRelation и schedule равны null!' . PHP_EOL);
        var_dump($cinemaHall);

        fwrite(STDOUT, 'Запрашиваем количество элементов в коллекции cinemaHallPlaceRelation: ' . $cinemaHall->getCinemaHallPlaceRelation()->count() . PHP_EOL);
        fwrite(STDOUT, 'Коллекция schedule по прежнему равна null.' . PHP_EOL);
//        var_dump($cinemaHall);

        fwrite(STDOUT, 'Запрашиваем количество элементов в коллекции schedule: ' . $cinemaHall->getSchedule()->count() . PHP_EOL);
        fwrite(STDOUT, 'Обе коллекции загружены!' . PHP_EOL);
//        var_dump($cinemaHall);
    }
}