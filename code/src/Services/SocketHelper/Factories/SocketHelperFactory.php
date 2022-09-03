<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\SocketHelper\Factories;

use Nsavelev\Hw6\Services\SocketHelper\Interfaces\SocketHelperInterface;
use Nsavelev\Hw6\Services\SocketHelper\SocketHelper;

class SocketHelperFactory
{
    /**
     * @return SocketHelperInterface
     */
    public static function getInstance(): SocketHelperInterface
    {
        return new SocketHelper();
    }
}