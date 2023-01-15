<?php

namespace Otus\Task11\Core\Command\Contracts;


use Otus\Task11\Core\Http\Request;

interface CommandProcessorContract
{
    public function getCommand(Request $request);
    public function execute();
}