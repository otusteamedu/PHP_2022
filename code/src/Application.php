<?php

namespace Svatel\Code;

use Svatel\Code\Builder\ClientElastic;
use Svatel\Code\Commands\IndexCommand;
use Svatel\Code\Commands\SearchCommand;
use Svatel\Code\Helper\ConsoleHelp;

class Application
{
    public static function create(array $argv)
    {
        $client = ClientElastic::build();
        switch ($argv[1]) {
            case 'index':
                $command = new IndexCommand($client);
                $res = $command->create();
                $res ? print_r('Индексирование прошло успешно') : print_r('Произошла ошибка при индексировании');
                break;
            case 'search':
                $command = new SearchCommand($client, $argv[2] ?? null);
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