<?php

declare(strict_types=1);

namespace App;

use App\Chat\Command\ExecutableInterface;

class App
{
    public function run(array $arguments): void
    {
        $argument = $arguments[1] ?? '';
        $fqn = __NAMESPACE__ . '\\' . 'Chat\\Command' . '\\' . \ucfirst(\strtolower($argument));

        if (\class_exists($fqn) && \in_array(ExecutableInterface::class, \class_implements($fqn))) {
            /** @var ExecutableInterface $command */
            $command = new $fqn($this->getConfigByArgument($argument));
            $command->execute();
        } else {
            throw new \RuntimeException('Некорректный аргумент ' . $argument);
        }
    }

    private function getConfigByArgument(string $argument): array
    {
        $configFile = APP_DIR . '/config/chat/command/' . $argument . '.php';
        if (\file_exists($configFile)) {
            return require_once $configFile;
        }

        return [];
    }
}