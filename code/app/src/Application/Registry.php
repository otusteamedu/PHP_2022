<?php
declare(strict_types = 1);

namespace Ppro\Hw27\App\Application;

class Registry
{
    private static $instance = null;
    private $request = null;
    private $conf = null;
    private $commands = null;
    private $views = null;
    private $environment = null;
    private $applicationHelper = null;

    private function __construct()
    {
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function reset()
    {
        self::$instance = null;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        if (is_null($this->request)) {
            throw new \Exception("No Request set");
        }

        return $this->request;
    }

    public function getApplicationHelper(): ApplicationHelper
    {
        if (is_null($this->applicationHelper)) {
            $this->applicationHelper = new ApplicationHelper();
        }

        return $this->applicationHelper;
    }

    public function setConf(Conf $conf)
    {
        $this->conf = $conf;
    }

    public function getConf(): Conf
    {
        if (is_null($this->conf)) {
            $this->conf = new Conf();
        }

        return $this->conf;
    }

    public function setCommands(Conf $commands)
    {
        $this->commands = $commands;
    }

    public function getCommands(): Conf
    {
        return $this->commands;
    }

    public function setViews(Conf $views)
    {
        $this->views = $views;
    }

    public function getViews(): Conf
    {
        return $this->views;
    }

    public function setEnvironment(Conf $environment)
    {
        $this->environment = $environment;
    }

    public function getEnvironment(): ?Conf
    {
        return $this->environment;
    }
}
