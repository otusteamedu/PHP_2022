<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw4;

class SessionProvider {

    const MEMCACHED_PORT = 11211;

    public function __construct(string $session_handler = 'files') {
        if ($session_handler === 'memcached') {
            ini_set('session.save_handler', $session_handler);
            ini_set('session.save_path', $session_handler . ':' . self::MEMCACHED_PORT);
        }
    }

    /**
     * 
     * @return $this
     */
    public function start() {
        session_start();
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function get_info_message(): string {
        $message = '<br>PHP Контейнер ID: ' . $_SERVER['HOSTNAME'] . ' <br>Session ID: ' . session_id() . PHP_EOL;
        return $message;
    }

}
