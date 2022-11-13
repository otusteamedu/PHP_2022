<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello page</title>
</head>
<body>
    <h2>Hi, user!</h2>
<?php

require '../vendor/autoload.php';

echo '<p>PHP works</p>';
echo '<p>Кириллица выводится корректно</p>';
echo '<p>Тест БД</p>';
// проверка подключения к БД
$dsn = 'pgsql:dbname=app;host=db';
$user = 'app';
$password = 'app';

$dbh = new PDO($dsn, $user, $password);
$x = $dbh->query('SELECT datname FROM pg_database;')->fetchAll();
echo '<pre>';
var_dump($x);
echo '</pre>';

// проверка подключения к Redis
$redis = new Redis();
$redis->connect('redis');
echo '<p>Redis сервер работает: ' . $redis->ping() . '</p>';

$memcache = new Memcache;
$memcache->connect('memcache', 11211) or die ('Не удается подключиться к Memcache');
$version = $memcache->getVersion();
echo "<p>Подключение к Memcache успешно. Версия " . $version . "</p>";

$generator = new \AndrewMarkhai\StathamPhraseGenerator\Generator();
$phrase = $generator->createPhrase();
echo '<p>Фраза от Стэтхэма: ' . $phrase . '</p>';
?>
</body>
</html>