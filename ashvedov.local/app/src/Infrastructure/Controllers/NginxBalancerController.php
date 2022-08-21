<?php

declare(strict_types=1);

namespace App\Src\Infrastructure\Controllers;

use App\Src\Domain\NginxBalancer\NginxWork;
use eftec\bladeone\BladeOne;

final class NginxBalancerController
{
    private NginxWork $nginx_work;

    public function __construct()
    {
        $this->nginx_work = new NginxWork();
    }

    /**
     * @throws \Exception
     */
    public function showcaseWork(): void
    {
        $views = __DIR__ . '/../../../src/Views';
        $cache = __DIR__ . '/../../../src/Bootstrap/cache';

        try {
            $blade = new BladeOne(templatePath: $views, compiledPath: $cache,mode: BladeOne::MODE_DEBUG);

            echo $blade->run(
                view: 'demonstration_work_balancer',
                variables: $this->nginx_work->demonstrate(),
            );
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
