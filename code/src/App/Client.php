<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\App;

use Nikcrazy37\Hw6\App\Socket;
use Nikcrazy37\Hw6\App\Config;

class Client
{
    private Socket $sock;

    public function __construct()
    {
        $this->sock = new Socket(Config::getOption("SOCK_FILE_NAME"));
    }

    /**
     * @return void
     */
    public function run()
    {
        echo "Введите сообщение:" . "\n";

        while (true) {
            $message = trim(fgets(STDIN)) . PHP_EOL;

            $this->sock->create();

            if ($this->sock->connect()) {
                $this->sock->write($message);
            }
        }
    }
}