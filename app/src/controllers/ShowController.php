<?php

namespace Mselyatin\Project15\src\controllers;

use Mselyatin\Project15\src\common\imaps\IdentityMap;
use Mselyatin\Project15\src\common\storages\DbStorage;
use Mselyatin\Project15\src\datamapper\mappers\CarMapper;

/**
 * Class DataMapperSolutionController
 * @package Mselyatin\Project15\src\controllers
 */
class ShowController
{
    /**
     * Запускает решение с DataMapper паттерном
     */
    public function runDataMapperSolution(): void
    {
        try {
            $db = DbStorage::getInstance(
                '192.168.31.165',
                'user',
                'user',
                'user'
            );

            $mapper = new CarMapper($db, IdentityMap::getInstance());

            $carById = $mapper->findById(1);
            $allCars = $mapper->all();

            echo 'Выгрзка одной модели по id' . PHP_EOL;

            echo '<pre>';
            var_dump($carById);
            echo '</pre>';

            echo 'Выгрузка всей таблицы: ' . PHP_EOL;

            echo '<pre>';
            var_dump($allCars);
            echo '</pre>';

        } catch (\Exception $e) {
            echo 'Error:' . PHP_EOL;
            echo $e->getMessage();
            die();
        }
    }
}