<?php

namespace Otus\Task13\Core\Command;


use Otus\Task13\Core\Command\Contracts\CommandProcessorContract;
use Otus\Task13\Core\Http\Request;
use ReflectionClass;

class CommandProcessor implements CommandProcessorContract
{

    public function __construct(private readonly array $commands)
    {
    }

    public function getCommand(Request $request): Command|null
    {

        $class = $this->commands[$request->getPath()];
        if (class_exists($class)) {
            $reflection = new ReflectionClass($class);
            if ($reflection->isSubclassOf(Command::class)) {
                return new $class(new InputContractCommand($request->getProperties()), new OutputCommand());
            }
        }

        return null;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }
}