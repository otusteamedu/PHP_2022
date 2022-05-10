<?php
declare(strict_types=1);


namespace Otus\SocketApp\Application\Service;


final class LogService // add interface
{
    public function display(string $message): void
    {
        echo date('Y-m-d H:i:s') . ' LogService.php' . $message . PHP_EOL;
    }
}