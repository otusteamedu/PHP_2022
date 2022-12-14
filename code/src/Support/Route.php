<?php

namespace Koptev\Support;

use Koptev\Exceptions\MethodNotAllowedException;
use Koptev\Exceptions\NotFoundException;

class Route
{
    protected array $get = [];
    protected array $post = [];
    private static Route $instance;

    private function __construct()
    {
    }

    /**
     * @return Route
     */
    public static function instance(): Route
    {
        if (empty(self::$instance)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /**
     * @param $uri
     * @param $action
     * @return void
     */
    public static function get($uri, $action)
    {
        $route = static::instance();
        $route->get[$uri] = $action;
    }

    /**
     * @param $uri
     * @param $action
     * @return void
     */
    public static function post($uri, $action)
    {
        $route = static::instance();
        $route->post[$uri] = $action;
    }

    /**
     * @return void
     */
    public function load()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/../config/routes.php';
    }

    /**
     * @param Request $request
     * @return array
     * @throws NotFoundException|MethodNotAllowedException
     */
    public function getAction(Request $request): array
    {
        $uri = $request->uri();

        if ($request->isMethodGet()) {
            if (isset($this->get[$uri])) {
                return $this->get[$uri];
            }

            if (isset($this->post[$uri])) {
                throw new MethodNotAllowedException('Method POST is not supported for this url.');
            }

            throw new NotFoundException('Url not found.');
        } elseif ($request->isMethodPost()) {
            if (isset($this->post[$uri])) {
                return $this->post[$uri];
            }

            if (isset($this->get[$uri])) {
                throw new MethodNotAllowedException('Method GET is not supported for this url.');
            }

            throw new NotFoundException('Url not found.');
        }

        throw new MethodNotAllowedException('Method ' . $request->method() . ' is not supported.');
    }
}
