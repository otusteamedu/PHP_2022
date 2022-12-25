<?php

namespace Otus\Task06\Core\Command;


use Otus\Task06\Core\Command\Contracts\CommandProcessorContract;
use Otus\Task06\Core\Http\Request;

class CommandProcessor implements CommandProcessorContract
{

    public function __construct(private readonly array $commands){}

    public function getCommand(Request $request): Command | null
    {

        $class = $this->commands[$request->getPath()];
        if(class_exists($class)){
            $reflection = new \ReflectionClass($class);
            if($reflection->isSubclassOf(Command::class)){

                return new $class();
            }
        }

        return null;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }
}