<?php

declare(strict_types=1);

namespace Nikolai\Php\ControllerResolver;

class ConsoleCommandControllerResolver implements ControllerResolverInterface
{
    const POSTFIX_CONTROLLER = 'Controller';
    const DEFAULT_CONTROLLER = 'Default';
    const METHOD_CONTROLLER = '__invoke';
    const NAMESPACE = 'Nikolai\Php\Controller\\';

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
            $controller = self::NAMESPACE . ucfirst($this->command) . self::POSTFIX_CONTROLLER;
            if (class_exists($controller) && method_exists($controller, self::METHOD_CONTROLLER)) {
                return $controller;
            }
        }

        return self::NAMESPACE . self::DEFAULT_CONTROLLER . self::POSTFIX_CONTROLLER;
    }
}