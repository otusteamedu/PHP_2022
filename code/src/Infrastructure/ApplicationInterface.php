<?php

namespace Cookapp\Php\Infrastructure;

/**
 * App interface
 */
interface ApplicationInterface
{
    /**
     * @return void
     */
    public function run(): void;
}
