<?php

namespace Ppro\Hw13\Views;

use League\CLImate\TerminalObject\Dynamic\InputAbstract;
use Ppro\Hw13\Cli\Climate;
use Ppro\Hw13\Data\EventDTO;

class AddView implements ViewInterface
{
    private array $input = [];

    public function render()
    {
        $climate = new Climate();
        $climate->setHeader('Add new Event');
        $this->input['NAME'] = $climate->renderInput("enter Event Name")->prompt();
        $this->input['PRIORITY'] = $climate->renderInputInt("enter Priority")->prompt();
        $climate->setComment('Type params (example:param1 1), each on a new line, Enter & ^D for continue');
        $this->input['PARAMS'] = $climate->renderMultilineInput("params>>")->prompt();
    }

    public function getEventData(): EventDTO
    {
        return new EventDTO($this->input['NAME'], (int)$this->input['PRIORITY'],$this->input['PARAMS']);
    }
}