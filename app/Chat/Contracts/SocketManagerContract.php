<?php
declare(strict_types=1);

namespace Otus\Task07\App\Chat\Contracts;


interface SocketManagerContract
{
    public function initialize();
    public function start();
}