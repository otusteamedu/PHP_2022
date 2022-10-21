<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Service;

use Nikolai\Php\Domain\Entity\CinemaHall;
use Nikolai\Php\Domain\Entity\CinemaHallPlaceRelation;
use Nikolai\Php\Domain\Entity\Film;
use Nikolai\Php\Domain\Entity\Place;
use Nikolai\Php\Domain\Entity\Schedule;
use Nikolai\Php\Domain\Mapper\MapperInterface;

class AddTestDataService
{
    const COUNT_ROWS = 10;
    const COUNT_COLS = 50;

    public function __construct(private MapperInterface $mapper) {}

    public function execute(): void
    {
/*
        $this->insertFilms();
        $this->insertCinemaHalls();
        $this->insertPlaces();
        $this->insertCinemaHallPlaceRelations();
        $this->insertSchedule();
*/
        $this->insertTickets();
    }

    private function insertTickets(): void
    {
        
    }

    private function insertSchedule(): void
    {
        $countSchedule = 0;
        $durationBreak = 15;
        $beginingDateTime = new \DateTime('2022-10-21 08:00:00');
        $endDateTime = new \DateTime('2022-10-22 02:00:00');

        $films = $this->mapper->findBy(Film::class, []);
        $cinemaHalls = $this->mapper->findBy(CinemaHall::class, []);

        foreach ($cinemaHalls as $cinemaHall) {
            $date = clone $beginingDateTime;
            while ($date->getTimestamp() < $endDateTime->getTimestamp()) {
                $randomFilm = rand(0, count($films) - 1);
                $schedule = new Schedule(null, $date->format('m/d/Y H:i:s'), $films[$randomFilm], $cinemaHall);
                $this->mapper->insert($schedule);
                $date->add(new \DateInterval('PT' . $films[$randomFilm]->getDuration() + $durationBreak . 'M'));
                $countSchedule++;
            }
        }

        fwrite(STDOUT, 'Вставлено: ' . $countSchedule . ' сеансов.' . PHP_EOL);
    }

    private function insertCinemaHallPlaceRelations(): void
    {
        $countCinemaHallPlaceRelations = 0;
        $places = $this->mapper->findBy(Place::class, []);
        $cinemaHalls = $this->mapper->findBy(CinemaHall::class, []);
        foreach ($cinemaHalls as $cinemaHall) {
            $countRowsCinemaHall = rand(3, self::COUNT_ROWS);
            $countColsCinemaHall = rand(10, self::COUNT_COLS);

            foreach ($places as $place) {
                if ($place->getRow() <= $countRowsCinemaHall &&
                $place->getCol() <= $countColsCinemaHall) {
                    $cinemaHallPlaceRelation = new CinemaHallPlaceRelation(null, $cinemaHall, $place);
                    $this->mapper->insert($cinemaHallPlaceRelation);
                    $countCinemaHallPlaceRelations++;
                }
            }
        }

        fwrite(STDOUT, 'Вставлено: ' . $countCinemaHallPlaceRelations . ' связей мест и кинозалов.' . PHP_EOL);
    }

    private function insertPlaces(): void
    {
        for ($i = 1; $i <= self::COUNT_ROWS; $i++) {
            for ($j = 1; $j <= self::COUNT_COLS; $j++) {
                $place = new Place(null, $i, $j);
                $this->mapper->insert($place);
            }
        }

        fwrite(STDOUT, 'Вставлено: ' . self::COUNT_ROWS * self::COUNT_COLS . ' мест.' . PHP_EOL);
    }

    private function insertCinemaHalls(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $cinemaHall = new CinemaHall(null, 'Кинозал ' . $i);
            $this->mapper->insert($cinemaHall);
        }

        fwrite(STDOUT, 'Вставлено: ' . $i - 1 . ' кинозалов.' . PHP_EOL);
    }

    private function insertFilms(): void
    {
        $countInsertedFilms = 0;
        $films = [
            ['Иван Васильевич меняет профессию', 90, 500.0],
            ['Зеленая миля', 130, 700.0],
            ['Побег из Шоушенка', 120, 600.0],
            ['Бриллиантовая рука', 95, 600.0],
            ['Джентльмены удачи', 85, 450.0],
            ['Москва слезам не верит', 150, 650.0],
            ['Служебный роман', 100, 500.0],
            ['Собачье сердце', 105, 450.0],
            ['Начало', 125, 550.0],
            ['Титаник', 140, 600.0],
            ['Властелин колец: Возвращение короля', 155, 680.0],
            ['Властелин колец: Две крепости', 135, 530.0],
            ['Властелин колец: Братство кольца', 130, 510.0]
        ];

        foreach ($films as $item) {
            $film = new Film(null, $item[0], $item[1], $item[2]);
            $this->mapper->insert($film);
            $countInsertedFilms++;
        }

        fwrite(STDOUT, 'Вставлено: ' . $countInsertedFilms . ' фильмов.' . PHP_EOL);
    }
}