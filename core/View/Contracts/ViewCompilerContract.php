<?php

namespace Otus\Task13\Core\View\Contracts;

interface ViewCompilerContract
{
    public function render(): string;
}