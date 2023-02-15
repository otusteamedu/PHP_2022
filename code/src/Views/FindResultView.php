<?php

namespace Ppro\Hw15\Views;

use Ppro\Hw15\Cli\Climate;

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
        if(!empty($this->result)) {
            $climate->setSuccess('Session found: ', true);
            $climate->renderColumns($this->result);
        } else
            $climate->setError('Session not found',true);

    }
}