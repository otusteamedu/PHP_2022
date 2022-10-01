<?php

declare(strict_types=1);

namespace Nikolai\Php;

use Nikolai\Php\Configuration\ConfigurationLoader;
use Nikolai\Php\Kernel\Kernel;
use Nikolai\Php\Service\Dumper;
use Nikolai\Php\Service\DumperInterface;
use Symfony\Component\HttpFoundation\Request;

class Application implements ApplicationInterface
{
    private DumperInterface $dumper;

    public function __construct()
    {
        (new ConfigurationLoader())->load();
        $this->dumper = new Dumper();
    }

    public function run(): void
    {
        try {
            $request = Request::createFromGlobals();
            $response = (new Kernel())->process($request);
            $response?->send();
        } catch (\Exception $exception) {
            $this->dumper->dump('Исключение: ' . $exception->getMessage());
        }
    }
}