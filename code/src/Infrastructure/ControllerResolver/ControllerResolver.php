<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\ControllerResolver;

use Symfony\Component\HttpFoundation\Request;

class ControllerResolver implements ControllerResolverInterface
{
    const POSTFIX_CONTROLLER = 'Controller';
    const DEFAULT_CONTROLLER = 'Default';

    public function __construct(private Request $request, private array $configuration) {}

    public function resolve(): string
    {
        $controllerClass = '';

        $uri = $this->request->server->get('REQUEST_URI');
        $method = $this->request->server->get('REQUEST_METHOD');
        $argv = $this->request->server->get('argv');

        if ($uri && $method) {
            if (array_key_exists($uri, $this->configuration['routes'][$method])) {
                $controllerClass = $this->configuration['routes'][$method][$uri];
            }
        } elseif (count($argv) >= 2) {
            $consoleCommand = $argv[1];
            if ($consoleCommand && preg_match("/^[a-zA-Z0-9]+$/", $consoleCommand)) {
                $controllerClass = $this->getControllerNamespace() . ucfirst($consoleCommand) . self::POSTFIX_CONTROLLER;
            }
        }

        if (class_exists($controllerClass)) {
            return $controllerClass;
        }

        return $this->getControllerNamespace() . self::DEFAULT_CONTROLLER . self::POSTFIX_CONTROLLER;
    }

    private function getControllerNamespace(): string
    {
        $namespaceLevelUp = substr(__NAMESPACE__, 0, strrpos(__NAMESPACE__, '\\') + 1);
        return $namespaceLevelUp . self::POSTFIX_CONTROLLER . '\\';
    }
}