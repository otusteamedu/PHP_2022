<?php

declare(strict_types=1);

namespace App\Src\Domain\DemonstrationWorkBalancer;

use eftec\bladeone\BladeOne;

session_start();

final class BalancerController
{
    /**
     * @throws \Exception
     */
    public function demonstrate(): void
    {
        $_SESSION['server_hostname'] = $_SERVER['HOSTNAME'];

        $views = __DIR__ . '/../../../src/Views';
        $cache = __DIR__ . '/../../../src/Bootstrap/cache';

        try {
            $blade = new BladeOne(templatePath: $views, compiledPath: $cache,mode: BladeOne::MODE_DEBUG);

            echo $blade->run(
                view: 'demonstration_work_balancer',
                variables: [
                    'server_hostname' => $_SERVER['HOSTNAME'],
                    'server_ip' => $_SERVER['SERVER_ADDR'],
                    'server_host_port' => $_SERVER['SERVER_PORT'],
                    'session_id' => session_id(),
                    'session_server_hostname' => $_SESSION['server_hostname'],
                ]
            );
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
