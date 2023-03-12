<?php

namespace Ppro\Hw27\Consumer\Application;

class Request
{
    private static ?self $instance = null;
    protected $cmd = "";

    private function __construct()
    {
        $this->init();
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    private function init()
    {
        $this->cmd = strtolower($_SERVER['argv'][1] ?? '');
    }

    /**
     * @return string
     */
    public function getCmd(): string
    {
        return $this->cmd;
    }
}