<?php

namespace Otus\Task12\Core\Command\Contracts;


use Otus\Task12\Core\Http\Request;

interface CommandProcessorContract
{
    public function getCommand(Request $request);
    public function execute();
}