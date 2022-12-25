<?php
declare(strict_types=1);

namespace Otus\Task06\App\Chat\Contracts;


interface SocketManagerContract
{
    public function initialize();
    public function start();
}