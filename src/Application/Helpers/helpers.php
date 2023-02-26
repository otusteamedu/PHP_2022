<?php

declare(strict_types=1);

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Src\Application\Bootstrap\DependencyContainer;

if (! function_exists('app')) {
    /**
     * @param string $dependency
     * @return mixed|DependencyContainer
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    function app(string $dependency = ''): mixed
    {
        if (empty($dependency)) {
            return DependencyContainer::getInstance();
        }

        return DependencyContainer::getInstance()->make($dependency);
    }
}

if (! function_exists('twig')) {
    /**
     * @return Environment
     */
    function twig(): Environment
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../Infrastructure/Views');

        return new Environment(loader: $loader);
    }
}
