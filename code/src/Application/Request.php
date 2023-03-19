<?php

namespace Ppro\Hw20\Application;

class Request
{
    /**
     * @var $this |null
     */
    private static ?self $instance = null;

    protected string $order = '';
    protected array $sets = [];

    /**
     *
     */
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

    /**
     * @return void
     */
    private function init()
    {
        $opts = getopt('p:e:');
        $this->order = $opts['p'] ?? '';
        $this->sets = isset($opts['e']) ? (is_array($opts['e']) ? $opts['e'] : [$opts['e']]) : [];

    }

    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @return array
     */
    public function getSets(): array
    {
        return $this->sets;
    }
}