<?php
declare(strict_types = 1);

namespace Ppro\Hw27\Consumer\Application;

use Ppro\Hw27\Consumer\Application\Conf;

class Registry
{
    private static $instance = null;
    private $request = null;
    private $conf = null;
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

    /**
     * @return void
     */
    public static function reset()
    {
        self::$instance = null;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     * @throws \Exception
     */
    public function getRequest(): Request
    {
        if (is_null($this->request)) {
            throw new \Exception("No Request set");
        }

        return $this->request;
    }

    /**
     * @return ApplicationHelper
     */
    public function getApplicationHelper(): ApplicationHelper
    {
        if (is_null($this->applicationHelper)) {
            $this->applicationHelper = new ApplicationHelper();
        }

        return $this->applicationHelper;
    }

    /**
     * @param \Ppro\Hw27\Consumer\Application\Conf $conf
     * @return void
     */
    public function setConf(Conf $conf)
    {
        $this->conf = $conf;
    }

    /**
     * @return \Ppro\Hw27\Consumer\Application\Conf
     */
    public function getConf(): Conf
    {
        if (is_null($this->conf)) {
            $this->conf = new Conf();
        }

        return $this->conf;
    }

    /**
     * @param \Ppro\Hw27\Consumer\Application\Conf $environment
     * @return void
     */
    public function setEnvironment(Conf $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return \Ppro\Hw27\Consumer\Application\Conf|null
     */
    public function getEnvironment(): ?Conf
    {
        return $this->environment;
    }
}
