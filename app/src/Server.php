<?php

namespace app;

class Server extends Process {
    const PROCESS_NAME = 'server';

    /**
     * @throws \Exception
     */
    public function run() {

        while(1) {
            if (!socket_set_block($this->socket)) {
                $this->socketError("Не могу заблокировать сокет");
            }
            if (socket_recvfrom($this->socket, $message, 64 * 1024, 0, $source) === false) {
                $this->socketError("Не могу получить сообщение");
            }

            echo "Получено сообщение: ".$message;
            $messageLength = strlen($message);
            $reply = 'Получено '. $messageLength. ' байт.';

            if (!socket_set_nonblock($this->socket)) {
                $this->socketError('Не могу разблокировать сокет');
            }

            if (socket_sendto($this->socket, $reply, strlen($reply), 0, $source) === false) {
                $this->socketError('Ошибка при отправке уведомления');
            }
        }
        // выход из цикла не предусматривается, запуск скрипта при имеющемся sock файле допустим,
        // поэтому socket_close() не использую
    }
}
