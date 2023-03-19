<?php

namespace Svatel\Code;

use Svatel\Code\Builder\ClientElastic;
use Svatel\Code\Commands\CreateCommand;
use Svatel\Code\Commands\SearchCommand;
use Svatel\Code\Helper\ConsoleHelp;

class Application
{
    /**
     * @throws \Exception
     */
    public static function create(array $argv)
    {
        $client = ClientElastic::build();
        switch ($argv[1]) {
            case 'create':
                if (isset($argv[2])) {
                    if (!isset($argv[3])) {
                        throw new \Exception('Введите путь до файла индекса');
                    }
                    $command = new CreateCommand($client, $argv[2], $argv[3], $argv[4] ?? null);
                } else {
                    throw new \Exception('Введите название индекса');
                }
                $res = $command->create();
                $res ? print_r('Индексирование прошло успешно') : print_r('Произошла ошибка при индексировании');
                break;
            case 'search':
                if (!isset($argv[2])) {
                    throw new \Exception('Введите json строку или путь до файла для поиска');
                }
                $command = new SearchCommand($client, $argv[2]);
                $res = $command->search();
                ConsoleHelp::generateResult($res);
                break;
            case 'help':
                print_r(ConsoleHelp::commands());
                break;
            default:
                print_r('Введите валидный аргумент');
        }
    }
}
