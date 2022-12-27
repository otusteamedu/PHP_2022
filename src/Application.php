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
        $this->printTasks();
        $this->printMovies();
    }

    protected function printTasks(): void
    {
        $statement = $this->pdo->prepare('SELECT * FROM movies_tasks');

        $statement->execute();

        echo '<table border="1" width="1000" style="text-align: center; margin-bottom: 20px">';
        echo '<tr><th>Название фильма</th><th>Событие</th><th>Дата</th></tr>';
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $movie) {
            echo '<tr>';
            echo '<td>'. $movie['title'] .'</td>';
            echo '<td>'. $movie['name'] .'</td>';
            echo '<td>'. $movie['value'] .'</td>';
            echo '<tr>';
        }
    }

    protected function printMovies(): void
    {
        $statement = $this->pdo->prepare('SELECT * FROM movies');

        $statement->execute();

        echo '<table border="1" width="1000" style="text-align: center">';
        echo '<tr><th>Название фильма</th><th>Тип атрибута</th><th>Название атрибута</th><th>Значение</th></tr>';
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $movie) {
            echo '<tr>';
            echo '<td>'. $movie['title'] .'</td>';
            echo '<td>'. $movie['type'] .'</td>';
            echo '<td>'. $movie['name'] .'</td>';
            echo '<td>'. $movie['value'] .'</td>';
            echo '<tr>';
        }
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