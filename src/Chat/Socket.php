<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Chat;

class Socket
{
    public function __construct()
    {
        if (!\extension_loaded('sockets')) {
            throw new \RuntimeException('Расширение "сокеты" не установлено');
        }
    }

    public function create(int $domain = \AF_UNIX, int $type = \SOCK_DGRAM, int $protocol = 0): \Socket
    {
        $socket = \socket_create($domain, $type, $protocol);
        if (!$socket) {
            throw new \DomainException('Не удалось создать AF_UNIX сокет');
        }
        return $socket;
    }

    public function bindSocket(\Socket $socket, string $sockFilePath): void
    {
        if (!\socket_bind($socket, $sockFilePath)) {
            throw new \RuntimeException("Unable to bind to $sockFilePath");
        }
    }

    public function sendMessage(string $msg, \Socket $socket, string $sockFilePath): void
    {
        $this->setNonblock($socket);

        $len = \strlen($msg);

        $bytesSent = \socket_sendto($socket, $msg, $len, 0, $sockFilePath);

        $this->setBlock($socket);

        if ($bytesSent === -1) {
            throw new \DomainException('Произошла ошибка при отправке в сокет');
        }

        if ($bytesSent !== $len) {
            throw new \DomainException("$bytesSent отправлено, вместо ожидаемых $len");
        }
    }

    public function setNonblock(\Socket $socket): void
    {
        if (!\socket_set_nonblock($socket)) {
            throw new \RuntimeException('Не удалось установить nonblocking режим для сокета');
        }
    }

    public function setBlock(\Socket $socket): void
    {
        if (!\socket_set_block($socket)) {
            throw new \RuntimeException('Не удалось установить blocking режим для сокета');
        }
    }

    public function getMessage(\Socket $socket): ?string
    {
        $bytesReceived = \socket_recvfrom($socket, $data, 65536, 0, $address);

        if ($bytesReceived === -1) {
            throw new \RuntimeException('Произошла ошибка при чтении из сокета');
        }

        return $data;
    }

    public function getMessageWithBlock(\Socket $socket): ?string
    {
        $this->setBlock($socket);

        $bytesReceived = \socket_recvfrom($socket, $data, 65536, 0, $address);

        $this->setNonblock($socket);

        if ($bytesReceived === -1) {
            throw new \RuntimeException('Произошла ошибка при чтении из сокета');
        }

        return $data;
    }
}
