<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Chat;

class Socket
{
    private \Socket $socket;

    private string $senderSock;

    private string $recipientSock;

    public function __construct(string $senderSock, string $recipientSock)
    {
        if (!\extension_loaded('sockets')) {
            throw new \RuntimeException('Расширение "сокеты" не установлено');
        }
        $this->senderSock = $senderSock;
        $this->recipientSock = $recipientSock;
        $this->create();
        $this->bindSocket();
    }

    private function create(): void
    {
        $socket = \socket_create(\AF_UNIX, \SOCK_DGRAM, 0);
        if (!$socket) {
            throw new \DomainException('Не удалось создать AF_UNIX сокет');
        }
        $this->socket = $socket;
    }

    public function bindSocket(): void
    {
        if (!\socket_bind($this->socket, $this->senderSock)) {
            $errorMessage = $this->getLastErrorMessage();
            throw new \RuntimeException("Не удалось привязать сокет $this->senderSock. Причина $errorMessage");
        }
    }

    public function sendMessage(string $msg): void
    {
        $this->setNonblock();

        $len = \strlen($msg);

        $bytesSent = \socket_sendto($this->socket, $msg, $len, 0, $this->recipientSock);

        $this->setBlock();

        if ($bytesSent === -1) {
            throw new \DomainException('Произошла ошибка при отправке в сокет');
        }

        if ($bytesSent !== $len) {
            throw new \DomainException("$bytesSent отправлено, вместо ожидаемых $len");
        }
    }

    public function setNonblock(): void
    {
        if (!\socket_set_nonblock($this->socket)) {
            throw new \RuntimeException('Не удалось установить nonblocking режим для сокета');
        }
    }

    public function setBlock(): void
    {
        if (!\socket_set_block($this->socket)) {
            throw new \RuntimeException('Не удалось установить blocking режим для сокета');
        }
    }

    public function getMessage(): ?string
    {
        $bytesReceived = \socket_recvfrom($this->socket, $data, 65536, 0, $address);

        if ($bytesReceived === -1) {
            throw new \RuntimeException('Произошла ошибка при чтении из сокета');
        }

        return $data;
    }

    public function getMessageWithBlock(): ?string
    {
        $this->setBlock();

        $bytesReceived = \socket_recvfrom($this->socket, $data, 65536, 0, $address);

        $this->setNonblock();

        if ($bytesReceived === -1) {
            throw new \RuntimeException('Произошла ошибка при чтении из сокета');
        }

        return $data;
    }

    public function close(): void
    {
        \socket_close($this->socket);
        \unlink($this->senderSock);
    }

    private function getLastErrorMessage(): string
    {
        $lastError = \socket_last_error($this->socket);
        return \socket_strerror($lastError);
    }
}
