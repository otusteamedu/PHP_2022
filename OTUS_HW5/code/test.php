<?php
define("MEMCACHED_ADDR", $_ENV["MEMCACHE1"]);
define("MEMCACHED_ADDR2", $_ENV["MEMCACHE2"]);
?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Тестовая страница для запросов</title>
    <meta name="description" content="Тестовая страница для запросов">
    <meta name="viewport" content="width=device-width, initial-scale=1"

    <meta name="theme-color" content="#fafafa">
</head>

<body>

<p>Введите строку для проверки</p>

<form method="POST" action="/">
    <input type="text" name="string">
    <input type="submit" name="Проверить">
</form>

</body>

<h2>Отладочная информация:</h2>
<p>Запроc обработал сервер <b><?=$_SERVER['SERVER_ADDR']?></b></p>

<h2>Проверка Memcached - сервер А</h2>

<?php
try {
	$m = new Memcached();
	$m->addServer(MEMCACHED_ADDR, 11211);
} catch (Throwable $t) {
	?>
	<p style="color:red;">Кэш не работает! (<?=$t->getMessage()?>)</p>
<?php
} catch (Exception $e) {
	?>
	<p style="color:red;">Кэш не работает! (<?=$e->getMessage()?>)</p>
        <?php
}

if ($m) {
	$key = 'key_0';
	$test_data = time()."-A";
	$m->set($key, $test_data);
	?>
	<p>Уcтанавливаем значение: <?=$test_data?></p>
<?php
	
	$cached_data=$m->get($key);
	?>
	<p>Читаем значение: <?=$cached_data?></p>

<?php if ($cached_data==$test_data) {?>
	<p style="color:green;">Кэш работает!</p>
<?php } else {?>
		<p style="color:red;">Кэш не работает!</p>
            <?php }?>

            <?php }?>

<h2>Проверка Memcached - сервер Б</h2>

<?php
try {
	$m2 = new Memcached();
	$m2->addServer(MEMCACHED_ADDR2, 11211);
} catch (Throwable $t) {
	?>
	<p style="color:red;">Кэш не работает! (<?=$t->getMessage()?>)</p>
<?php
} catch (Exception $e) {
	?>
	<p style="color:red;">Кэш не работает! (<?=$e->getMessage()?>)</p>
        <?php
}

if ($m2) {
?>
        <?php
	
	$cached_data=$m2->get($key);
	?>
	<p>Читаем значение с мастера: <?=$cached_data?></p>
<?php
	$key = 'key_1';
	$test_data = time()."-B";
	$m2->set($key, $test_data);
	?>
	<p>Уcтанавливаем значение на slave: <?=$test_data?></p>
<?php
	
	$cached_data=$m2->get($key);
	?>
	<p>Читаем значение со slave: <?=$cached_data?></p>

<?php if ($cached_data==$test_data) {?>
	<p style="color:green;">Кэш работает!</p>
        <?php } else {?>
		<p style="color:red;">Кэш не работает!</p>
            <?php }?>

            <?php }?>

</html>