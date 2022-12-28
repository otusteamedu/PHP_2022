<?php

namespace Ppro\Hw13\Views;

use League\CLImate\TerminalObject\Dynamic\InputAbstract;
use Ppro\Hw13\Cli\Climate;
use Ppro\Hw13\Data\ParamsDTO;

class FindView implements ViewInterface
{
    private string $input = '';

    public function render()
    {
        $climate = new Climate();
        $climate->setHeader('Find Event');
        $climate->setComment('Type params (example:param1 1), each on a new line, Enter & ^D for continue');
        $this->input = $climate->renderMultilineInput('>')->prompt();
    }

    public function getParamsData(): ParamsDTO
    {
        return new ParamsDTO($this->input);
    }
}