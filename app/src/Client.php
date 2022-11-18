<?php

namespace app;

class Client extends Process {
    const PROCESS_NAME = 'client';
    private string $serverSocketFile;

    public function __construct() {
        parent::__construct();
        $this->serverSocketFile = $this->getSocketFilename(Server::PROCESS_NAME);
        $this->checkServer();
    }

    /**
     * @throws \Exception
     */
    public function run() {

        while(1) {
            $message = fgets(STDIN);

            if (!socket_set_nonblock($this->socket))
                $this->socketError('Не могу разблокировать сокет');

            if (socket_sendto($this->socket, $message, strlen($message), 0, $this->serverSocketFile) === false) {
                $this->socketError('Ошибка при отправке');
            }

            if (!socket_set_block($this->socket))
                $this->socketError('Не могу заблокировать сокет');

            if (socket_recvfrom($this->socket, $message, 64 * 1024, 0, $source) === false) {
                $this->socketError('Ошибка при получении');
            }

            echo "Ответ сервера: ".$message.PHP_EOL;
        }

        // выход из цикла не предусматривается, запуск скрипта при имеющемся sock файле допустим,
        // поэтому socket_close() не использую
    }

    public function checkServer() {
        if (!file_exists($this->serverSocketFile)) {
            throw new \Exception("Сначала запустите сервер.");
        }
    }
}
