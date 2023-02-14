<?php

namespace Ppro\Hw15\Views;

use League\CLImate\TerminalObject\Dynamic\InputAbstract;
use Ppro\Hw15\Cli\Climate;

class InitView implements ViewInterface
{
    private InputAbstract $input;
    public function render()
    {
        $climate = new Climate();
        $options  = ['FIND_SESSION' => 'Find Session','CHECK_IMAP' => 'Check Movie IdentityMap', 'EXIT' => 'Exit'];
        $this->input = $climate->renderRadio($options,'Select an action:',true);
    }

    public function getInput()
    {
        return $this->input;
    }

}