<?php

namespace Nikolai\Php\Service;

interface ServiceInterface
{
    const QUIT = '\q';

    public function run(): void;
}