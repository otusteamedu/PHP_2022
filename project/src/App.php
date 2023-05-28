<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw7;

class App {

    private $_mode = '';

    /**
     * 
     */
    public function __construct() {
        $this->_mode = (new RequestProvider)->get_argv(1);
    }

    /**
     * 
     * @return void
     */
    public function run(): void {
        $socket = SocketProvider::create_socket($this->_mode);
        $socket->start();
    }

}
