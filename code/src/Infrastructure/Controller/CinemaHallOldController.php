<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Domain\Entity\CinemaHall;
use Nikolai\Php\Infrastructure\Mapper\CinemaHallMapper;
use Symfony\Component\HttpFoundation\Request;

class CinemaHallOldController implements ControllerInterface
{
    const ALLOW_ACTIONS = [
        'insert',
        'update',
        'delete'
    ];

    public function __construct(private CinemaHallMapper $cinemaHallMapper) {}

    public function __invoke(Request $request)
    {
        $action = $request->server->get('argv')[2];
        $value = $request->server->get('argv')[3];

        fwrite(STDOUT, 'value:' . PHP_EOL);
        var_dump($value);

        $cinemaHall = new CinemaHall();
        $cinemaHall->setName($value);

        fwrite(STDOUT, 'cinema_hall до вставки:' . PHP_EOL);
        var_dump($cinemaHall);

        $this->cinemaHallMapper->insert($cinemaHall);

        fwrite(STDOUT, 'cinema_hall после вставки:' . PHP_EOL);
        var_dump($cinemaHall);


    }
}