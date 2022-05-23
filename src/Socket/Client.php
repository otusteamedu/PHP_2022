<?php

namespace Socket;

class Client extends Socket
{
    public function run(): void
    {
        while (true) {
            $this->showMessage('Введите сообщение (для выхода введите close):');

            $message = trim(fgets(STDIN));
            if (!$message) {
                continue;
            }

            $this->write($message);
            $this->showMessage(
                $this->read()
            );

            if ($message === self::EXIT_COMMAND) {
                $this->close();
                break;
            }
        }
    }

    private function showMessage(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    }
}
