<?php

declare(strict_types=1);

namespace App\Src\Domain\NginxBalancer;

session_start();

final class NginxWork
{
    /**
     * @return array
     */
    public function demonstrate(): array
    {
        $_SESSION['server_hostname'] = $_SERVER['HOSTNAME'];

        return [
            'server_hostname' => $_SERVER['HOSTNAME'],
            'server_ip' => $_SERVER['SERVER_ADDR'],
            'server_host_port' => $_SERVER['SERVER_PORT'],
            'session_id' => session_id(),
            'session_server_hostname' => $_SESSION['server_hostname'],
        ];
    }
}
