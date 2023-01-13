<?php

namespace app\Domain\Process;


class ChatClientService extends AbstractChatProcess {
    public function getName(): string {
        return 'client';
    }

    public function run(string $fileName): void {

        while(1) {
            $message = fgets(STDIN);

            $this->unblockSocket();

            if (socket_sendto($this->socket, $message, strlen($message), 0, $this->serverFileName) === false) {
                $this->socketError('Ошибка при отправке');
            }

            $this->blockSocket();

            if (socket_recvfrom($this->socket, $message, 64 * 1024, 0, $source) === false) {
                $this->socketError('Ошибка при получении');
            }

            echo "Ответ сервера: ".$message.PHP_EOL;
        }

        // выход из цикла не предусматривается, запуск скрипта при имеющемся sock файле допустим,
        // поэтому socket_close() не использую
    }
}
