<?php

declare(strict_types=1);

namespace App;

use App\Command\ExecutableInterface;

class App
{
    public function run(array $arguments): void
    {
        $argument = $arguments[1] ?? '';
        $fqn = __NAMESPACE__ . '\\' . 'Command' . '\\' . \ucfirst(\strtolower($argument));

        if (\class_exists($fqn) && \in_array(ExecutableInterface::class, \class_implements($fqn))) {
            /** @var ExecutableInterface $command */
            $command = new $fqn;
            $command->execute();
        } else {
            throw new \RuntimeException('Некорректный аргумент ' . $argument);
        }
    }
}