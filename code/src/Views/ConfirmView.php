<?php

namespace Ppro\Hw13\Views;

use League\CLImate\TerminalObject\Dynamic\Confirm;
use Ppro\Hw13\Cli\Climate;

class ConfirmView implements ViewInterface
{
    private Confirm $input;
    public function render(string $msg = 'Do you want to continue?')
    {
        $climate = new Climate();
        $this->input = $climate->renderConfirmation($msg);
    }

    public function confirmed(): bool
    {
        if(isset($this->input))
            return $this->input->confirmed();
        return false;
    }

}