<?php

use App\Framework\IdentityMap;

require_once './../vendor/autoload.php';

// опускаем всю нормальную архитектуру и напрямую хардкодим данные сюда для проверки паттернов
// так это все должен прокидывать DI контейнер
$pdo = new \PDO('pgsql:host=postgres;port=5432;dbname=postgres', 'root', 'postgres');

$mapper = new App\Mappers\FilmMapper($pdo);

$film1 = $mapper->findById(1);

echo "{$film1->getTitle()} ({$film1->getDescription()})" . '<br>';

$film1->setDescription('New description 2');
$mapper->update($film1);

$mapper->insert([
    'title' => 'Титаник',
    'description' => 'Грустный фильм иногда',
    'poster' => 'link',
    'premier_date' => '1990-01-02',
]);

$film2 = $mapper->insert([
    'title' => 'Аватар',
    'description' => 'Уже не очень грустный фильм',
    'poster' => 'link',
    'premier_date' => '2008-01-02',
]);

echo "{$film2->getTitle()} ({$film2->getDescription()})" . '<br>';

$mapper->delete($film2);

echo '<br>Все фильмы:<br>';

foreach($mapper->getAll() as $film) {
    echo "{$film->getTitle()} ({$film->getDescription()})" . '<br>';
}
