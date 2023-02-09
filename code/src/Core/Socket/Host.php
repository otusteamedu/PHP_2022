<?php

declare(strict_types=1);

namespace Kogarkov\Chat\Core\Socket;

class Host
{
    private $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public function get(): string
    {
        return $this->host;
    }

    public function initialize(): void
    {
        if ($this->exists()) {
            $this->remove();
        }
    }

    private function exists(): bool
    {
        return file_exists($this->host);
    }

    private function remove(): void
    {
        unlink($this->get());
    }
}
