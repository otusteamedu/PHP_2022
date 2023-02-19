<?php

namespace Otus\Task13\Core\Command\Contracts;


use Otus\Task13\Core\Http\Request;

interface CommandProcessorContract
{
    public function getCommand(Request $request);

    public function execute();
}