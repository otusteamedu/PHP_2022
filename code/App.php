<?php

declare(strict_types=1);

namespace App;

use App\Domain\Options\AppOptions;
use DI\{Container, ContainerBuilder, DependencyException, NotFoundException};
use Exception;

class App
{
    protected AppOptions $appOptions;

    private Container $container;

    /**
     * @throws Exception
     */
    public function __construct(array $argv)
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(APP_PATH.'/config.php');
        $this->container = $builder->build();

        $this->appOptions = new AppOptions($argv);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(): void
    {
        $chat = $this->container->get('chat.'.$this->appOptions->getAppType());
        $chat->run();
    }
}