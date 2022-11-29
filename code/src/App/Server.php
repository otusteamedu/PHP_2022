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
        if (file_exists(Config::SOCK_FILE_NAME)) {
            unlink(Config::SOCK_FILE_NAME);
        }

        $this->sock = new Socket(Config::SOCK_FILE_NAME);
    }

    /**
     * @return mixed
     */
    public function run()
    {
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