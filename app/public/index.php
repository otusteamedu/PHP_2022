<?php
declare(strict_types=1);

use DI\ContainerBuilder;

require '../vendor/autoload.php';

/**
 * Собираем DI контейнер
 */
$appContainerDefinitions = require '../src/boostrap.php';
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions($appContainerDefinitions);
$appContainer = $containerBuilder->build();

/**
 * Получаем и запускаем приложение
 */
$app = $appContainer->get('app');
$app->run();
