<?php

namespace Ppro\Hw15\Views;

use Ppro\Hw15\Cli\Climate;

class ResultView implements ViewInterface
{
    private bool $result;
    private string $successMsg = 'Operation finished without errors';
    private string $errorMsg = 'Operation finished with errors';

    public function __construct(bool $result = true, string $successMsg = "", string $errorMsg = "")
    {
        $this->result = $result;
        $this->successMsg = $successMsg ?: $this->successMsg;
        $this->errorMsg = $errorMsg ?: $this->errorMsg;
    }

    public function render(): void
    {
        $climate = new Climate();
        $this->result ? $climate->setSuccess($this->successMsg) : $climate->setError($this->errorMsg);
    }
}