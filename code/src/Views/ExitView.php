<?php

namespace Ppro\Hw13\Views;

use League\CLImate\TerminalObject\Dynamic\Confirm;
use Ppro\Hw13\Cli\Climate;

class ExitView implements ViewInterface
{
    private Confirm $input;
    public function render()
    {
        $climate = new Climate();
        $this->input = $climate->renderConfirmation('Do you want to exit?');
    }

    public function getInput()
    {
        return $this->input;
    }

    public function exitConfirmed(): bool
    {
        if(isset($this->input))
            return $this->input->confirmed();
        return false;
    }

}