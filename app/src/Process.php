<?php

namespace app;

abstract class Process {
    public $socket;
    public string $ownSocketFilename;

    public function __construct() {
        $this->checkExt();
        $processName = static::PROCESS_NAME;
        $this->ownSocketFilename = $this->getSocketFilename($processName);
        $this->socket = $this->createSocket();
    }

    public function getSocketFilename($suffix) {
        $dir = parse_ini_file(__DIR__ . '/../config/sockets.ini');
        if (empty($dir['socket_dir'])) {
            throw new \Exception('Отсутствует настройка директории socket файла');
        }
        return $dir['socket_dir'] . '/'.$suffix.'.sock';
    }

    public function createSocket($fileName = null) {
        if (!$fileName) {
            $fileName = $this->ownSocketFilename;
        }
        if (file_exists($fileName)) unlink($fileName);
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (socket_bind($socket, $fileName) === false) {
            $this->socketError("Ошибка при выполнении socket_bind(): " . socket_strerror(socket_last_error($this->socket)));
        }
        return $socket;
    }

    public function socketError($message) {
        throw new \Exception($message. ': ' . socket_strerror(socket_last_error($this->socket)));
    }

    private final function checkExt() {
        if (!extension_loaded('sockets')) {
            throw new \Exception('The sockets extension is not loaded.');
        }
    }
}
