<?php

namespace Api;
session_start();
header('Access-Control-Allow-Origin: http://frontend.local');

class Router {

    private array $routes;

    private string $route;
    private string $string;

    public object $api;

    public function __construct()
    {
        $this->routes = [
            'brackets' => '\Api\BracketsCounter',
            'emails' => '\Api\EmailsAnalyzer',
        ];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $data = $_POST;
        }

        $this->route = $data['route'] ?? '';
        $this->string = $data['string'] ?? '';

        if ($this->route && $this->string) {
            if (class_exists($this->routes[$this->route])) {
                $this->api =
                    new $this->routes[$this->route]($this->string);
            }
        }
    }

    /**
     * @throws ApiException
     */
    public function getApi(): object
    {
        if (isset($this->api)) {
            return $this->api;
        }
        throw new ApiException(ApiException::emptyPost());
    }
}
