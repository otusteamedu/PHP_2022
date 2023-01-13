<?php

namespace app\Domain\Process;


class ChatServerService extends AbstractChatProcess {
    public function getName(): string {
        return 'server';
    }

    public function run(string $fileName): void {

        while(1) {
            $this->blockSocket();

            if (socket_recvfrom($this->socket, $message, 64 * 1024, 0, $source) === false) {
                $this->socketError("Не могу получить сообщение");
            }

            echo "Получено сообщение: ".$message;
            $messageLength = strlen($message);
            $reply = 'Получено '. $messageLength. ' байт.';

            $this->unblockSocket();

            if (socket_sendto($this->socket, $reply, strlen($reply), 0, $source) === false) {
                $this->socketError('Ошибка при отправке уведомления');
            }
        }
        // выход из цикла не предусматривается, запуск скрипта при имеющемся sock файле допустим,
        // поэтому socket_close() не использую
    }
}
