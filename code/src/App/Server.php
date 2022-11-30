<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\App;

use Nikcrazy37\Hw6\App\Socket;
use Nikcrazy37\Hw6\Exception\SocketException;
use Nikcrazy37\Hw6\App\Config;

class Server
{
    private Socket $sock;

    public function __construct()
    {
        $file = Config::getOption("SOCK_FILE_NAME");
        if (file_exists($file)) {
            unlink($file);
        }

        $this->sock = new Socket($file);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        echo "Добро пожаловать на сервер!" . PHP_EOL;

        $this->sock->create();

        $this->sock->bind();

        $this->sock->listen();

        while (true) {
            $this->sock->accept();
            echo $this->sock->read();
        }

        $this->sock->close();
    }
}