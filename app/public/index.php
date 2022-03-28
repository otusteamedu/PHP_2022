<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use hw4\core\App;

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
 * @var App $app
 */
$app = $appContainer->get('app');

$app->setContainer($appContainer);
$app->run();
