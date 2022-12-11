<?php

declare(strict_types=1);

namespace App\Src\Infrastructure\Cli;

use App\Src\Controllers\CliController;
use App\Src\Repositories\RepositoryDTO;

use function cli\{line, menu, prompt};

final class CliDialog
{
    private CliController $controller;

    /**
     * class constructor
     */
    public function __construct()
    {
        $this->controller = new CliController();
    }

    /**
     * @return void
     */
    public function startDialog(): void
    {
        line(
            msg: 'Добро пожаловать в \'Систему Событий\'' . PHP_EOL
            . 'Используется БД: ' . $_ENV['REPOSITORY'] . PHP_EOL
            . 'Выберите что вы хотите сделать (ввести порядковый номер):'
        );

        $menu = [
            1 => 'Добавить событие',
            2 => 'Получить событие',
            3 => 'Получить все события',
            4 => 'Удалить все события',
            5 => 'Удалить конкртеное событие'
        ];

        $answer = 'y';

        while (in_array(needle: $answer, haystack: ['y', 'yes', 'д', 'да'])) {
            $selected_menu_item = menu(
                items: $menu,
                default: false,
                title: 'Ваш выбор'
            );

            if (!isset($menu[$selected_menu_item])) {
                line(msg: 'Выбран неверный пункт меню.' . PHP_EOL);
                $answer = prompt(question: 'Продолжить работу?');

                continue;
            }

            match ((int)$selected_menu_item) {
                1 => $this->controller->addEvent(
                    repository_dto: new RepositoryDTO(
                        key: prompt(question: 'Введите ключ'),
                        score: (int)prompt(question: 'Введите ранг'),
                        conditions: prompt(question: 'Введите условия события'),
                        event_description: prompt(question: 'Введите описание события'),
                    )
                ),
                2 => $this->controller->getConcreteEvent(
                    repository_dto: new RepositoryDTO(
                        key: prompt(question: 'Введите ключ'),
                        conditions: prompt(question: 'Введите условия события')
                    )
                ),
                3 => $this->controller->getAllEvents(
                    repository_dto: new RepositoryDTO(key: prompt(question: 'Введите ключ'))
                ),
                4 => $this->controller->deleteAllEvents(),
                5 => $this->controller->deleteConcreteEvent(
                    repository_dto: new RepositoryDTO(
                        key: prompt(question: 'Введите ключ'),
                        conditions: prompt(question: 'Введите условия события'),
                        event_description: prompt(question: 'Введите описание события'),
                    )
                ),
            };

            $answer = prompt(question: 'Продолжить работу?');
        }
    }
}
