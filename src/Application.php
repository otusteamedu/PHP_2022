<?php

namespace Mselyatin\Patterns;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
class Application
{
    /** @var Application|null $this  */
    public static ?self $app = null;

    /** @var ContainerInterface|null  */
    public static ?ContainerInterface $container = null;

    /** @var Request|null  */
    public ?Request $request = null;

    /** @var array  */
    private array $config = [];

    /**
     * Start application
     *
     * @param array $config
     * @return void
     * @throws \Exception
     */
    public function run(array $config): void
    {
        if (static::$app === null) {
            $this->config = $config;
            static::$app = $this;
        }

        if (static::$container === null) {
            $this->initContainer();
        }

        if ($this->request === null) {
            $this->request = new Request(
                $_GET,
                $_POST,
                [],
                $_COOKIE,
                $_FILES,
                $_SERVER
            );
        }
    }

    private function initContainer(): void
    {
        $definitions = $this->config['diconfig'] ?? [];
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($definitions);

        static::$container = $containerBuilder->build();
    }
}