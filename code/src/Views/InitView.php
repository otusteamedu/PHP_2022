<?php

namespace Ppro\Hw13\Views;

use League\CLImate\TerminalObject\Dynamic\InputAbstract;
use Ppro\Hw13\Cli\Climate;

class InitView implements ViewInterface
{
    private InputAbstract $input;
    public function render()
    {
        $climate = new Climate();
        $options  = ['ADD_EVENT' => 'Add Event', 'FIND_EVENT' => 'Find Event', 'REMOVE_EVENT' => 'Remove all Events', 'EXIT' => 'Exit'];
        $this->input = $climate->renderRadio($options,'Select an action:',true);
    }

    public function getInput()
    {
        return $this->input;
    }

}