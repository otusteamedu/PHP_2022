<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\ControllerResolver;

class ControllerResolver implements ControllerResolverInterface
{
    const POSTFIX_CONTROLLER = 'Controller';
    const DEFAULT_CONTROLLER = 'Default';

    private ?string $command;

    public function __construct(?string $command)
    {
        $this->command = $command;
    }

    /**
     * Возвращает строку класса контроллера: $command . 'Controller', если такой класс существует,
     * иначе - 'DefaultController'.
     * Например: если $command = createIndex, то вернется CreateIndexController.
     */
    public function resolve(): string
    {
        if ($this->command && preg_match("/^[a-zA-Z0-9]+$/", $this->command)) {
            $controller = $this->getControllerNamespace() . ucfirst($this->command) . self::POSTFIX_CONTROLLER;
            if (class_exists($controller)) {
                return $controller;
            }
        }

        return $this->getControllerNamespace() . self::DEFAULT_CONTROLLER . self::POSTFIX_CONTROLLER;
    }

    private function getControllerNamespace(): string
    {
        $namespaceLevelUp = substr(__NAMESPACE__, 0, strrpos(__NAMESPACE__, '\\') + 1);
        return $namespaceLevelUp . self::POSTFIX_CONTROLLER . '\\';
    }
}