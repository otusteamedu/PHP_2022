<?php


namespace Study\Cinema;

use Study\Cinema\ActiveRecord\Movie;
use Study\Cinema\DataMapper\Session;
use Study\Cinema\DataMapper\SessionMapper;
use Study\Cinema\RowGateway\DaysType;
use Study\Cinema\TableGateway\Hall;
use DateTimeImmutable;
use Study\Cinema\Helper\DotEnv;
use PDO;

class App
{
    public function run()
    {

        (new DotEnv(__DIR__ . '/../.env'))->load();
        $pdo = (new DBConnection())->getConnection();
        $hall = new Hall($pdo);


        $hall = new Hall($pdo);
        $hallId = $hall->insert("Оливковый", 0.5, 25);


        $movie = new Movie($pdo);
        $movie->setPrice('1500');
        $movie->setName("Тираны красного моря");
        $movie->insert();

        $days = new DaysType($pdo);
        $days->setName("Среда");
        $days->setRate(0.75);
        $days->insert();

        $session = new Session(null, $hallId,$movie->getId(),$days->getId(), 1002, (new DateTimeImmutable('2023-01-25 12:15')) ->format('Y-m-d H:i:s.u')  );
        $dataMapper = new SessionMapper($pdo);
        $dataMapper->insert($session);

        $hall->update(24,seats_number: 57);

    }

}