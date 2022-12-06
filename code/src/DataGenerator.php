<?php

namespace Study\Cinema;

use PDO;

class DataGenerator
{
    private PDO|null $pdo;
    public function __construct()
    {
        try {
            $dsn = "pgsql:host=postgres;port=5432;dbname=test_t;";
            $user = 'user';
            $password = 'password';
            $db = 'test_t';
            $this->pdo = new PDO( $dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] );

            if ($this->pdo ) {
                echo "Connected to the $db database successfully!";
            }

        } catch (PDOException $e) {
            die( $e->getMessage() );
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function InsertDataIntoSession()
    {
        //  $this->pdo = $this->getConnection();
        $day = 1;
        $movies = $this->getMovies();
        $days_types  = $this->getDaysType();
        while($day <= 30){

            $date = '2023-12-'.$day;
            $day++;
            $halls = $this->getHalls();
            $days_type = $days_types[array_rand($days_types)];
            foreach($halls as $hall) {// идем по залам
                $hall['hall_id'];
                $times = $this->getTimeTypes();
                foreach($times as $time){ //>=start < finish
                    $sql = 'insert into session (hall_id, movie_id, days_type_id, started_at,  price,  created_at, updated_at)
                    values(:hall_id, :movie_id, :days_type_id, :started_at,  :price, now(), now())';
                    // prepare statement
                    $statement = $this->pdo->prepare($sql);
                    // bind params
                    $dt = $date.' '.$time['mintime']; //DateTime::createFromFormat('d-m-Y H:i:s', );


                    $movie = $movies[array_rand($movies)];
                    $price = max($movie['price'], 400)*$hall['rate']*$days_type['rate']*$time['rate'];
                    $statement->bindParam(':hall_id', $hall['hall_id'], PDO::PARAM_INT);
                    $statement->bindParam(':movie_id', $movie['movie_id'], PDO::PARAM_INT);
                    $statement->bindParam(':days_type_id', $days_type['days_type_id'],PDO::PARAM_INT);
                    $statement->bindParam(':started_at', $dt);
                    $statement->bindParam(':price', $price);

                    if (!$statement->execute()) {
                        echo 'Ошибка вставки сеанса';
                    }

                }
            }
        }

    }

    public function getTimeTypes()
    {
        //  $this->pdo = $this->getConnection();
        $stmt = $this->pdo->query('SELECT time_type_id, mintime, rate FROM time_type ORDER BY time_type_id');
        $times = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC))
        {
            $times[] = [
                'time_type_id' => $row['time_type_id'],
                'rate' => $row['rate'],
                'mintime' => $row['mintime'],
            ];
        }
        return $times;
    }
    public function getDaysType()
    {
        // $this->pdo = $this->getConnection();
        $stmt = $this->pdo->query('SELECT days_type_id, rate  FROM days_type ORDER BY days_type_id');
        $days = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC))
        {
            $days[] = [
                'days_type_id' => $row['days_type_id'],
                'rate' => $row['rate'],
            ];
        }
        return $days;
    }
    public function getMovies()
    {
        // $this->pdo = $this->getConnection();
        $stmt = $this->pdo->query('SELECT movie_id, price  FROM movie ORDER BY movie_id');
        $data = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC))
        {
            $data[] = [
                'movie_id' => $row['movie_id'],
                'price' => $row['price'],

            ];
        }
        return $data;
    }
    public function getHalls()
    {
        //$this->pdo = $this->getConnection();
        $stmt = $this->pdo->query('SELECT hall_id, rate FROM hall ORDER BY hall_id');
        $times = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC))
        {
            $times[] = [
                'hall_id' => $row['hall_id'],
                'rate' => $row['rate'],
            ];
        }
        return $times;
    }

}