<?php

namespace Otus\Task06\Core\Command\Contracts;


use Otus\Task06\Core\Http\Request;

interface CommandProcessorContract
{
    public function getCommand(Request $request);
    public function execute();
}