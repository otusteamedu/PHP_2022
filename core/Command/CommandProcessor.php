<?php

namespace Otus\Task10\Core\Command;


use Otus\Task10\Core\Command\Contracts\CommandProcessorContract;
use Otus\Task10\Core\Http\Request;

class CommandProcessor implements CommandProcessorContract
{

    public function __construct(private readonly array $commands){}

    public function getCommand(Request $request): Command | null
    {

        $class = $this->commands[$request->getPath()];
        if(class_exists($class)){
            $reflection = new \ReflectionClass($class);
            if($reflection->isSubclassOf(Command::class)){
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