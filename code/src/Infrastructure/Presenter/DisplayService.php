<?php
declare(strict_types=1);


namespace Otus\SocketApp\Application\Service;


final class DisplayService implements LoggerInterface
{
    public function info(string $message): void
    {
        echo date('Y-m-d H:i:s') . ' LogService.php' . $message . PHP_EOL;
    }
}