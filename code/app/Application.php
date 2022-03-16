<?php

namespace App;

use Core\Base\Response;
use Core\Base\Router;
use Core\Base\Session;
use Core\Base\Validator;
use Core\Components\Request;
use Core\Exceptions\InvalidArgumentException;

class Application
{
    /**
     * @var string $baseDir
     * @var string $controllersNamespace
     * @var string $baseController
     * @var string $errorAction
     */
    protected string $baseDir;
    protected string $controllersNamespace = '\\App\\Controllers';
    protected string $baseController = 'site';
    protected string $errorAction = 'site/error';
    protected Request $request;
    protected Router $router;
    protected Response $response;
    protected Session $session;
    protected Validator $validator;
    static public Application $app;

    public function __construct(array $config = [])
    {
        $this->preInit($config);
        $this->setInstance($this);
        $this->request = new Request();
        $this->router = new Router();
        $this->response = new Response();
        $this->session = new Session();
        $this->validator = new Validator();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function run() :void
    {
        $this->router->init();
    }

    /**
     * @param array $config
     * @return void
     */
    public function preInit(array $config) :void
    {
        if (count($config) > 0) {
            foreach ($config as $key => $param) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $param;
                }
            }
        }
    }

    /**
     * @param Application $instance
     * @return void
     */
    private function setInstance(Application $instance) :void
    {
        self::$app = $instance;
    }

    /**
     * @return Request
     * @throws InvalidArgumentException
     */
    public function getRequest() :Request
    {
        return $this->get('request');
    }

    /**
     * @return Router
     * @throws InvalidArgumentException
     */
    public function getRouter() :Router
    {
        return $this->get('router');
    }

    /**
     * @return Response
     * @throws InvalidArgumentException
     */
    public function getResponse() :Response
    {
        return $this->get('response');
    }

    /**
     * @return Session
     * @throws InvalidArgumentException
     */
    public function getSession() :Session
    {
        return $this->get('session');
    }

    /**
     * @return Validator
     * @throws InvalidArgumentException
     */
    public function getValidator() :Validator
    {
        return $this->get('validator');
    }

    /**
     * @param string $property
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        throw new InvalidArgumentException(__METHOD__ . ': Undefined Property');
    }
}