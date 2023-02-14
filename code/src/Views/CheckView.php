<?php

namespace Ppro\Hw15\Views;

use League\CLImate\TerminalObject\Dynamic\InputAbstract;
use Ppro\Hw15\Cli\Climate;
use Ppro\Hw15\Data\ParamsDTO;

class CheckView implements ViewInterface
{
    private string $input = '';

    public function render()
    {
        $climate = new Climate();
        $climate->setHeader('Check IdentityMap');
        $climate->setComment('IdentityMap type (on/off)');
        $this->input = $climate->renderInput('>')->prompt();
    }

    public function getParamsData(): string
    {
        return $this->input;
    }
}