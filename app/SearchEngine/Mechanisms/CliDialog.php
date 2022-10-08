<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms;

use function cli\{line, menu, prompt};
use App\SearchEngine\Mechanisms\DTO\QueryParamsDTO;

final class CliDialog
{
    private array $configuration;

    /**
     * class constructor
     */
    public function __construct()
    {
        $configuration_instance = Configuration::getInstance();
        $this->configuration = $configuration_instance->getConfig();
    }

    /**
     * @return QueryParamsDTO
     */
    public function startDialog(): QueryParamsDTO
    {
        line(
            msg: 'Добро пожаловать в \'Поиск книг\'' . PHP_EOL
            . 'Выберите категорию из списка (ввести порядковый номер):'
        );

        $menu = $this->configuration['dialog_menu'];
        $menu_map = $this->configuration['dialog_menu_map'];

        $answer = 'y';
        $query_parameters_dto = new QueryParamsDTO();

        // TODO: добавить выбор количества выдаваемых результатов (максимально 10 000)

        while (in_array(needle: $answer, haystack: ['y', 'yes', 'д', 'да'])) {
            $selected_menu_item = menu(
                items: $menu,
                default: false,
                title: 'Ваш выбор'
            );

            if (! isset($menu_map[$selected_menu_item])) {
                line(msg: 'Выбран неверный параметр.' . PHP_EOL);
                $answer = prompt(question: 'Продолжить выбор параметров?');

                continue;
            }

            $internal_key = $menu_map[$selected_menu_item]['internal_key'];
            $mutually_exclusive_field = $menu_map[$selected_menu_item]['mutually_exclusive_field'] ?? '';
            $parameter = $menu_map[$selected_menu_item]['transliterate'];

            if (! empty($query_parameters_dto->$internal_key)) {
                line(msg: 'Уже введено. Выберите другой параметр поиска или завершите ввод' . PHP_EOL);
                continue;
            }

            /*
             * чтобы нельзя было выбрать title_list, если уже выбран title
             */
            if (! empty($query_parameters_dto->$mutually_exclusive_field)) {
                line(
                    msg: 'Выбрано взаимоисключающее поле. Выберите другой параметр поиска или завершите ввод' . PHP_EOL
                );
                continue;
            }

            if (! empty($menu_map[$selected_menu_item]['explanation'])) {
                line(msg: $menu_map[$selected_menu_item]['explanation'] . PHP_EOL);
            }

            $query_parameters_dto->$internal_key = prompt(question: 'Введите значение для ' . $parameter);

            $answer = prompt(question: 'Продолжить выбор параметров?');
        }

        $query_parameters_dto->number_of_results =
            prompt(question: 'Введите количество резлультатов поиска. по умолчанию - ', default: '10');

        return $query_parameters_dto;
    }
}
