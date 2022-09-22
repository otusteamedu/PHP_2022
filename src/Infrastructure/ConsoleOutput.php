<?php

namespace App\Infrastructure;

class ConsoleOutput implements \App\Application\Contracts\ResponseInterface
{
    //Простейший класс для вывода данных в поток
    public function out(string $message)
    {
        echo $message;
    }
}