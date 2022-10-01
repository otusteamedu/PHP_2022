<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\App;

use Nsavelev\Hw6\App\Console\Commands\ClientCommand;
use Nsavelev\Hw6\App\Console\Commands\ServerCommand;
use Nsavelev\Hw6\App\Exceptions\NoArgumentException;
use Nsavelev\Hw6\App\Exceptions\WrongArgumentException;
use Nsavelev\Hw6\App\Interfaces\AppInterface;

class App implements AppInterface
{
    /** @var string */
    private const ALLOWED_ARGUMENT_SERVER = 'server';

    /** @var string */
    private const ALLOWED_ARGUMENT_CLIENT = 'client';

    /** @var string[] */
    private const ALLOWED_ARGUMENTS = [
        self::ALLOWED_ARGUMENT_SERVER,
        self::ALLOWED_ARGUMENT_CLIENT,
    ];

    /**
     * @param $argc
     * @param $argv
     * @return string
     * @throws NoArgumentException
     * @throws WrongArgumentException
     */
    public function run($argc, $argv): string
    {
        if (!array_key_exists(1, $argv)) {
            throw new NoArgumentException('No argument.');
        }

        $argument = $argv[1];

        if (!in_array($argument, self::ALLOWED_ARGUMENTS, true))
        {
            throw new WrongArgumentException('Wrong argument.');
        }

        switch ($argument) {
            case self::ALLOWED_ARGUMENT_SERVER:
            {
                (new ServerCommand)->handle();
                break;
            }

            case self::ALLOWED_ARGUMENT_CLIENT:
            {
                (new ClientCommand())->handle();
                break;
            }
        }

        return 'ok';
    }
}