<?php

namespace Ppro\Hw13\Views;

use Ppro\Hw13\Cli\Climate;

class FindResultView implements ViewInterface
{
    private array $result;

    public function __construct(array $result = [])
    {
        $this->result = $result;
    }

    public function render(): void
    {
        $climate = new Climate();
        $climate->setSuccess('Events found: '.count($this->result),true);
        if(!empty($this->result))
            $climate->renderColumns($this->result);
    }
}