<?
//Адреса по умолчанию для NAT
define("MEMCACHED_ADDR", '10.0.2.2');
define("REDIS_ADDR", '10.0.2.2')?>
<!DOCTYPE html>
<html lang="ru">
	<head>
	  <meta name="description" content="Webpage description goes here" />
	  <meta charset="utf-8">
	  <title>Server diagnostic page</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
	<h1>Server diagnostic page</h1>
	<?php
	echo "Текущая дата: ".date("Y-m-d H:i:s") ."<br>";
	?>
	<h2>Проверка Memcached</h2>
	<?
	try {
		$m = new Memcached();
		$m->addServer(MEMCACHED_ADDR, 11211);
	} catch (Throwable $t) {
		?>
		<p style="color:red;">Кэш не работает! (<?=$t->getMessage()?>)</b>
		<?
	} catch (Exception $e) {
		?>
		<p style="color:red;">Кэш не работает! (<?=$e->getMessage()?>)</b>
		<?
	}
	
	if ($m) {
		$key = 'key_0';
		$test_data = time();
		$m->set($key, $test_data);
		?>
		<p>Уcтанавливаем значение: <?=$test_data?></p>
		<?
		
		$cached_data=$m->get($key);
		?>
		<p>Читаем значение: <?=$cached_data?></p>
		
		<?if ($cached_data==$test_data) {?>
		<p style="color:green;">Кэш работает!</b>
		<?} else {?>
			<p style="color:red;">Кэш не работает!</b>
		<?}?>
	
	<?}?>

	<h2>Проверка Redis</h2>
	<?
	try {
		$redis = new Redis();
		$redis->connect(MEMCACHED_ADDR, 6379);
	} 
	catch (Throwable $t)
	{
	   ?>
		<p style="color:red;">Redis не работает! (<?=$t->getMessage()?>)</b>
		<?
	}
	catch (Exception $e) {
		?>
		<p style="color:red;">Redis не работает! (<?=$e->getMessage()?>)</b>
		<?
	}
	
	if ($redis) {
		$key = 'key_0';
		$test_data = time();
		$redis->set($key, $test_data);
		?>
		<p>Уcтанавливаем значение: <?=$test_data?></p>
		<?
		
		$cached_data=$redis->get($key);
		?>
		<p>Читаем значение: <?=$cached_data?></p>
		
		<?if ($cached_data==$test_data) {?>
		<p style="color:green;">Redis работает!</b>
		<?} else {?>
			<p style="color:red;">Redis не работает!</b>
		<?}?>
	
	<?}?>


	</body>
</html>
