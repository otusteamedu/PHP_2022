<?php

namespace Dkozlov\Otus;

use PDO;

class Application
{

    private PDO $pdo;

    private Config $config;

    public function __construct()
    {
        $this->config = new Config(__DIR__ . '/../config/config.ini');
        $this->pdo = $this->constructPDO();
    }

    public function run(): void
    {
        $film = $this->getProfitableFilm();

        if ($film) {
            $result = 'Самый прибыльный фильм &laquo;' . $film['title'] . '&raquo; собрал ' . $film['total'] . ' рублей';
        } else {
            $result = 'Самый прибыльный фильм не найден';
        }

        echo $result;
    }

    protected function getProfitableFilm(): mixed
    {
        $query = "SELECT title, total FROM (
            SELECT t.*, rank() over (order by total desc) as r FROM (
                SELECT sum(cost) as total, films.title as title FROM tickets
                    JOIN sessions on tickets.session_id = sessions.id
                    JOIN films on sessions.film_id = films.id
                    GROUP BY films.id
            ) as t
        ) as t2
        WHERE r = 1";

        $sth = $this->pdo->prepare($query);
        $sth->execute();

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    protected function constructPDO(): PDO
    {
        $dsn = 'pgsql:host=' . $this->config->get('db_host') . ';';
        $dsn .= 'port=' . $this->config->get('db_port') . ';';
        $dsn .= 'dbname=' . $this->config->get('db_name');

        return new PDO(
            $dsn,
            $this->config->get('db_username'),
            $this->config->get('db_password')
        );
    }
}