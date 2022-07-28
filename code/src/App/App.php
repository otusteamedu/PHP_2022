<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\App;

use Nsavelev\Hw6\App\Interfaces\AppInterface;

class App implements AppInterface
{
    /**
     * @param $argc
     * @param $argv
     * @return string
     */
    public function handle($argc, $argv): string
    {

        return 'ok';
    }
}