<?php

declare(strict_types=1);

namespace Eliasj\Hw16\App\Kernel;

use Exception;

trait Singleton
{
    private static ?self $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): self
    {

        if (is_null(self::$instance)) {
            self::$instance =  new self();
        }

        return self::$instance;
    }
}
