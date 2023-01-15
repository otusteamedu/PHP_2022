<?php

namespace Otus\Task10\Core\Command\Contracts;


use Otus\Task10\Core\Http\Request;

interface CommandProcessorContract
{
    public function getCommand(Request $request);
    public function execute();
}