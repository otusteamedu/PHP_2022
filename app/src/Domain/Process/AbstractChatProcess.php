<?php

namespace app\Domain\Process;


abstract class AbstractChatProcess implements ChatProcessInterface {
    public $socket;
    protected string $serverFileName;
    protected string $ownSocketFilename;

    public function __construct(string $ownSocketFilename, string $serverFileName) {
        $this->ownSocketFilename = $ownSocketFilename;
        $this->serverFileName = $serverFileName;
        $this->checkExt();
        $this->socket = $this->createSocket();
    }

    /**
     * Ругается, если сделать typehint
     * @return false|resource|\Socket
     * @throws \Exception
     */
    public function createSocket() {
        $fileName = $this->ownSocketFilename;
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (socket_bind($socket, $fileName) === false) {
            $this->socketError("Ошибка при выполнении socket_bind(): " . socket_strerror(socket_last_error($this->socket)));
        }
        return $socket;
    }

    public function socketError($message) {
        throw new \Exception($message. ': ' . socket_strerror(socket_last_error($this->socket)));
    }

    private final function checkExt(): void {
        if (!extension_loaded('sockets')) {
            throw new \Exception('The sockets extension is not loaded.');
        }
    }

    protected function unblockSocket() {
        if (!socket_set_nonblock($this->socket))
            $this->socketError('Не могу разблокировать сокет');
    }

    protected function blockSocket() {
        if (!socket_set_block($this->socket))
            $this->socketError('Не могу заблокировать сокет');
    }

}
