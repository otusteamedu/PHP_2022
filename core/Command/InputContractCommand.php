<?php

namespace Otus\Task11\Core\Command;

use Otus\Task11\Core\Command\Contracts\InputContractContract;

class InputContractCommand implements InputContractContract
{
    public function __construct(private array $arguments){
        $this->arguments = array_slice($this->arguments, 2);
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }
}