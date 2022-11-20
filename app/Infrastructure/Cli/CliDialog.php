<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli;

use App\Core\Kernel;
use App\Controllers\CliController;
use function cli\{line, menu, prompt};

final class CliDialog
{
    private CliController $controller;

    public function __construct()
    {
        $kernel = Kernel::getInstance();
        $kernel->initializeCliApplication();

        $this->controller = new CliController();
    }

    /**
     * @return void
     */
    public function startDialog(): void
    {
        line(
            msg: '\'ПОИСК ДАННЫХ ИСПОЛЬЗУЯ РАЗНЫЕ ПАТТЕРНЫ\'' . PHP_EOL
            . 'Используется паттерн: ' . $_ENV['DB_SEARCH_PATTERN'] . PHP_EOL
            . 'Выберите что хотите сделать в таблице Ticket:'
        );

        $menu = [
            1 => 'Найти конкретный билет',
            2 => 'Найти все билеты',
            3 => 'Добавить билет',
            4 => 'Обновить билет',
            5 => 'Удалить конкретный билет',
        ];

        $selected_menu_item = menu(
            items: $menu,
            default: false,
            title: 'Ваш выбор'
        );

        match ((int) $selected_menu_item) {
            1 => $this->controller->find(ticket_id: (int) prompt(question: 'Введите id тикета')),
            2 => $this->controller->findAll(),
            3 => $this->controller->insert(raw_data: [
                'date_of_sale' => prompt(question: 'Введите дату продажи'),
                'time_of_sale' => prompt(question: 'Введите время продажи'),
                'customer_id' => (int) prompt(question: 'Введите id клиента'),
                'schedule_id' => (int) prompt(question: 'Введите id расписания'),
                'total_price' => prompt(question: 'Введите цену билета'),
                'movie_name' => prompt(question: 'Введите название фильма'),
            ]),
            4 => $this->controller->update(raw_data: [
                'id' => (int) prompt(question: 'Введите id тикета'),
                'date_of_sale' => prompt(question: 'Введите дату продажи'),
                'time_of_sale' => prompt(question: 'Введите время продажи'),
                'customer_id' => (int) prompt(question: 'Введите id клиента'),
                'schedule_id' => (int) prompt(question: 'Введите id расписания'),
                'total_price' => prompt(question: 'Введите цену билета'),
                'movie_name' => prompt(question: 'Введите название фильма'),
            ]),
            5 => $this->controller->delete(ticket_id: (int) prompt(question: 'Введите id тикета')),
        };

    }
}
