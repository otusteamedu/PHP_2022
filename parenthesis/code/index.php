<?php
declare(strict_types=1);

require_once "ParenthesisParser.php";

const STRING_IS_CORRECT = 'String is correct';

session_start();

$visits = $_SESSION["visits"] ?? 1;
$_SESSION["visits"] = $visits + 1;

$string = $_POST['string'];

$memcache = new Memcache();
$memcache->connect('memcached', 11211);

$stringCheckResultIsCached = true;
$stringCheckResult = $memcache->get($string);

if (!$stringCheckResult) {

    $stringCheckResultIsCached = false;
    $stringCheckResult = STRING_IS_CORRECT;

    try {
        $pp = new ParenthesisParser();
        $pp->checkExpression($string);
    } catch (Exception $e) {
        $stringCheckResult = $e->getMessage();
    }

    $memcache->set($string, $stringCheckResult);
}

if ($stringCheckResult !== STRING_IS_CORRECT) {
    http_response_code(400);
}

echo "Число ваших посещений: ${visits}\n";
echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . "\n";

if ($stringCheckResultIsCached) {
    echo "Результат обработки взят из кэша\n";
}

echo "${stringCheckResult}\n";
