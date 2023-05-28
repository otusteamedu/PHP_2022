<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw7;

class ChatSocket {

    protected $_socket = null;
    protected $_socket_path = '';

    public function __construct() {
        $config = new ConfigProvider();
        $this->_socket_path = $config->get_field('socket_path');
    }

    /**
     * 
     */
    public function start() {
        
    }

    /**
     * 
     * @return string
     */
    protected function _get_stdin_input(): string {
        $input = trim(fgets(STDIN));
        return $input;
    }

}
